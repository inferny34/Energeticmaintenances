/**
 * Zones d'intervention du programme apporteurs EMS.
 * Source : contrat d'apporteur V8 (article 1) et page-sections.html du prototype.
 *
 * TODO client : à valider — écart détecté avec la ZoneSection.vue du site principal :
 *   • Prototype/contrat V8 liste 11 depts : 07, 11, 12, 13, 30, 31, 34, 48, 66, 81, 83
 *   • Site principal (index.html JSON-LD + ZoneSection) liste 12 depts : 07, 09, 11, 12, 13, 30, 31, 34, 48, 66, 81, 84
 *   • Différences : contrat inclut 83 (Var) mais pas 09 (Ariège) ni 84 (Vaucluse).
 *   Cette liste est la référence contractuelle pour le formulaire d'apporteurs.
 */
export const ZONES = [
  { code: '34', label: 'Hérault', chip: '34 Hérault' },
  { code: '30', label: 'Gard', chip: '30 Gard' },
  { code: '11', label: 'Aude', chip: '11 Aude' },
  { code: '66', label: 'Pyrénées-Orientales', chip: '66 Pyrénées-Orientales' },
  { code: '12', label: 'Aveyron', chip: '12 Aveyron' },
  { code: '48', label: 'Lozère', chip: '48 Lozère' },
  { code: '81', label: 'Tarn', chip: '81 Tarn' },
  { code: '31', label: '· Haute-Garonne', chip: '31 · Haute-Garonne' },
  { code: '13', label: 'Bouches-du-Rhône', chip: '13 Bouches-du-Rhône' },
  { code: '83', label: 'Var', chip: '83 Var' },
  { code: '07', label: 'Ardèche', chip: '07 Ardèche' },
]

/** Set des codes département pour la validation rapide */
export const ZONE_CODES = new Set(ZONES.map(z => z.code))

/**
 * Vérifie si un code postal (5 chiffres) est dans la zone.
 * @param {string} postalCode
 * @returns {boolean|null} true=dans zone, false=hors zone, null=code incomplet
 */
export function isInZone(postalCode) {
  const code = String(postalCode).trim()
  if (code.length !== 5) return null
  return ZONE_CODES.has(code.slice(0, 2))
}
