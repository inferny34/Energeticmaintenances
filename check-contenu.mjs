#!/usr/bin/env node
/**
 * check-contenu.mjs
 * Vérifie que l'intégralité des contenus textuels de modif/source/page-sections.html
 * est bien présente dans les composants et sources de src/.
 *
 * Usage :
 *   node check-contenu.mjs modif/source/page-sections.html src
 */

import fs from 'fs';
import path from 'path';
import { parse } from '@vue/compiler-dom';

const sourceHtmlPath = process.argv[2] || 'modif/source/page-sections.html';
const srcDirPath = process.argv[3] || 'src';

if (!fs.existsSync(sourceHtmlPath)) {
  console.error(`Erreur : fichier source introuvable : ${sourceHtmlPath}`);
  process.exit(1);
}
if (!fs.existsSync(srcDirPath)) {
  console.error(`Erreur : dossier src introuvable : ${srcDirPath}`);
  process.exit(1);
}

// Nettoyage et normalisation des chaînes pour comparaison robuste
export function normalize(str) {
  if (!str) return '';
  return str
    .replace(/<[^>]+>/g, ' ')
    .replace(/&nbsp;/g, ' ')
    .replace(/&rsquo;/g, "'")
    .replace(/&lsquo;/g, "'")
    .replace(/&rdquo;/g, '"')
    .replace(/&ldquo;/g, '"')
    .replace(/&amp;/g, '&')
    .replace(/&euro;/g, '€')
    .replace(/[\u00a0\u202F\u2007]/g, ' ')
    .replace(/[\u2018\u2019\u201B\u02BC]/g, "'")
    .replace(/[\u201C\u201D\u201E]/g, '"')
    .replace(/\\u00a0/g, ' ')
    .replace(/\\u2019/g, "'")
    .replace(/\\u1d49/g, 'ᵉ')
    .replace(/\\"/g, '"')
    .replace(/\\'/g, "'")
    .replace(/\s+/g, ' ')
    .trim();
}

// Extraction du texte d'un nœud AST
function getNodeText(node) {
  if (!node) return '';
  if (node.type === 2) return node.content; // TEXT
  if (node.type === 1) return (node.children || []).map(getNodeText).join(' '); // ELEMENT
  return '';
}

// Liste des exceptions justifiées
const JUSTIFIED_EXCEPTIONS = [
  {
    pattern: /Aperçu du formulaire|Cette page de démonstration ne transmet aucune donnée|Le service d['’]envoi sera raccordé/i,
    reason: "Bannière d'aperçu (#preview-notice) : supprimée car le formulaire est désormais raccordé au backend réel (étape 4)."
  },
  {
    pattern: /^Imprimer$|imprimer-contrat\.html/i,
    reason: "Lien imprimer-contrat.html : remplacé par l'ouverture directe du PDF officiel contrat-apporteur-ems-v8.pdf (étape 4)."
  }
];

// Parser le HTML source
const htmlSource = fs.readFileSync(sourceHtmlPath, 'utf8');
const ast = parse(htmlSource);

const items = [];

function walk(node, parentTag = '') {
  if (!node) return;
  if (node.type === 1) { // ELEMENT
    const tag = node.tag;
    const id = node.props?.find(p => p.name === 'id')?.value?.content || '';
    const cls = node.props?.find(p => p.name === 'class')?.value?.content || '';

    // Éléments contenant du texte autonome
    if (['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'button', 'a', 'summary', 'option', 'legend', 'label', 'li'].includes(tag)) {
      const text = normalize(getNodeText(node));
      if (text.length > 0) {
        items.push({ tag, id, class: cls, text });
      }
    } else if (['span', 'div', 'strong', 'b'].includes(tag)) {
      // Tags inline/bloc qui ont du texte direct sans enfants blocs
      const hasBlockChild = (node.children || []).some(c => c.type === 1 && ['p', 'h1', 'h2', 'h3', 'h4', 'div', 'section', 'article', 'aside', 'ul', 'ol'].includes(c.tag));
      if (!hasBlockChild && (node.children || []).some(c => c.type === 2 && c.content.trim())) {
        const text = normalize(getNodeText(node));
        if (text.length > 0 && !['p', 'h1', 'h2', 'h3', 'h4', 'button', 'a', 'summary', 'option', 'legend', 'label', 'li'].includes(parentTag)) {
          items.push({ tag, id, class: cls, text });
        }
      }
    }

    if (node.children) {
      node.children.forEach(c => walk(c, tag));
    }
  }
}

ast.children.forEach(c => walk(c));

// Récupérer tous les fichiers de src/
function getFiles(dir, exts = ['.vue', '.js', '.json', '.html']) {
  let res = [];
  for (const item of fs.readdirSync(dir)) {
    const full = path.join(dir, item);
    const st = fs.statSync(full);
    if (st.isDirectory()) {
      if (item !== 'node_modules' && item !== '.git' && item !== 'dist') {
        res = res.concat(getFiles(full, exts));
      }
    } else if (exts.some(e => item.endsWith(e))) {
      res.push(full);
    }
  }
  return res;
}

const srcFiles = getFiles(srcDirPath);
const srcDatabase = srcFiles.map(f => ({
  file: f,
  raw: fs.readFileSync(f, 'utf8'),
  norm: normalize(fs.readFileSync(f, 'utf8'))
}));

const combinedSrcNorm = srcDatabase.map(s => s.norm).join(' ');

// Vérification de chaque texte
const presents = [];
const exceptes = [];
const absents = [];

for (const it of items) {
  // Vérifier d'abord les exceptions justifiées
  const exc = JUSTIFIED_EXCEPTIONS.find(e => e.pattern.test(it.text));
  if (exc) {
    exceptes.push({ ...it, reason: exc.reason });
    continue;
  }

  const query = it.text;
  let found = combinedSrcNorm.toLowerCase().includes(query.toLowerCase());

  if (!found) {
    // Si texte long (> 6 mots), tester par blocs de mots au cas où interpolé / découpé
    const words = query.split(' ').filter(w => w.length > 2);
    if (words.length > 6) {
      const half1 = words.slice(0, Math.floor(words.length / 2)).join(' ');
      const half2 = words.slice(Math.floor(words.length / 2)).join(' ');
      if (combinedSrcNorm.toLowerCase().includes(half1.toLowerCase()) && combinedSrcNorm.toLowerCase().includes(half2.toLowerCase())) {
        found = true;
      }
    }
  }

  if (found) {
    presents.push(it);
  } else {
    absents.push(it);
  }
}

// Affichage du rapport
console.log('=== VÉRIFICATION DU CONTENU SOURCE vs SRC ===');
console.log(`Source HTML : ${sourceHtmlPath} (${items.length} éléments textuels analysés)`);
console.log(`Cible src/  : ${srcDirPath} (${srcFiles.length} fichiers scannés)`);
console.log('---------------------------------------------');
console.log(`textes vérifiés       : ${items.length}`);
console.log(`présents              : ${presents.length}`);
console.log(`exceptions justifiées : ${exceptes.length}`);
console.log(`absents               : ${absents.length}`);

if (exceptes.length > 0) {
  console.log('\n--- Exceptions justifiées ---');
  exceptes.forEach((e, i) => {
    console.log(`  ${i + 1}. [${e.tag}] "${e.text.slice(0, 70)}..."`);
    console.log(`     -> Justification : ${e.reason}`);
  });
}

if (absents.length > 0) {
  console.log('\n--- Éléments absents détectés ---');
  absents.forEach((a, i) => {
    console.log(`  ${i + 1}. [${a.tag}] (id="${a.id}", class="${a.class}"): "${a.text}"`);
  });
  process.exit(1);
} else {
  console.log('\nRésultat : SUCCÈS (absents : 0)');
}
