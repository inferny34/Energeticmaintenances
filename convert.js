const sharp = require('sharp');
const fs = require('fs');

async function convert() {
  const logoPath = 'c:/Users/nicol/Desktop/Site-one-page/Site-test/ems/public/logo.png';
  const heroPath = 'c:/Users/nicol/Desktop/Site-one-page/Site-test/ems/public/hero_bg.png';
  
  await sharp(logoPath)
    .resize({ width: 200, height: 200, fit: 'inside' })
    .webp({ quality: 80 })
    .toFile('c:/Users/nicol/Desktop/Site-one-page/Site-test/ems/public/logo.webp');
    
  await sharp(heroPath)
    .resize({ width: 1920, height: 1080, fit: 'inside', withoutEnlargement: true })
    .webp({ quality: 80 })
    .toFile('c:/Users/nicol/Desktop/Site-one-page/Site-test/ems/public/hero_bg.webp');
    
  const logoStat = fs.statSync('c:/Users/nicol/Desktop/Site-one-page/Site-test/ems/public/logo.webp');
  const heroStat = fs.statSync('c:/Users/nicol/Desktop/Site-one-page/Site-test/ems/public/hero_bg.webp');
  
  console.log(`Logo WebP: ${logoStat.size} bytes`);
  console.log(`Hero WebP: ${heroStat.size} bytes`);
}

convert().catch(console.error);
