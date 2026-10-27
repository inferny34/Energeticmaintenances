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
  { code: '07', label: 'Ardèche' },
  { code: '11', label: 'Aude' },
  { code: '12', label: 'Aveyron' },
  { code: '13', label: 'Bouches-du-Rhône' },
  { code: '30', label: 'Gard' },
  { code: '31', label: 'Haute-Garonne' },
  { code: '34', label: 'Hérault' },
  { code: '48', label: 'Lozère' },
  { code: '66', label: 'Pyrénées-Orientales' },
  { code: '81', label: 'Tarn' },
  { code: '83', label: 'Var' },
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
