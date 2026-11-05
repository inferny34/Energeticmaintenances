(()=>{
 'use strict';
 const names=['devenir','recommander'];
 const tabs=names.map(n=>document.getElementById('choice-'+n));
 const panels=names.map(n=>document.getElementById(n));
 const forms=document.querySelector('#formulaires .forms');
 function choose(name,focus=false){
  const selected=names.includes(name)?name:'devenir';
  names.forEach((n,i)=>{const on=n===selected;tabs[i].setAttribute('aria-selected',String(on));tabs[i].tabIndex=on?0:-1;panels[i].hidden=!on;});
  if(focus)document.querySelector('#'+selected+' .ems-form-heading h3').focus({preventScroll:true});
 }
 document.getElementById('journey-choice').hidden=false;forms.classList.add('journey-active');
 tabs.forEach((tab,i)=>{
  tab.addEventListener('click',()=>choose(names[i]));
  tab.addEventListener('keydown',event=>{if(['ArrowLeft','ArrowRight','Home','End'].includes(event.key)){event.preventDefault();const index=event.key==='Home'?0:event.key==='End'?1:1-i;choose(names[index]);tabs[index].focus();}});
 });
 document.querySelectorAll('a[href="#devenir"],a[href="#recommander"]').forEach(link=>link.addEventListener('click',()=>choose(link.hash.slice(1),true)));
 window.addEventListener('hashchange',()=>{if(names.includes(location.hash.slice(1)))choose(location.hash.slice(1));});
 choose(names.includes(location.hash.slice(1))?location.hash.slice(1):'devenir');
 function files(){const inputs=[...document.querySelectorAll('#registration-form input[type=file]')];const count=inputs.filter(x=>x.files.length>0).length;document.getElementById('document-counter').textContent=count===4?'4 / 4 pièces jointes — EMS contrôlera les documents après réception.':`${count} / 4 pièces jointes — ajoutez les quatre fichiers pour envoyer votre dossier.`;}
 document.getElementById('registration-form').addEventListener('change',files);files();
 document.querySelectorAll('[data-loyalty-jump]').forEach(link=>link.addEventListener('click',event=>{event.preventDefault();choose('recommander');const section=document.getElementById('engagement-loyaute');section.scrollIntoView({behavior:window.matchMedia('(prefers-reduced-motion: reduce)').matches?'auto':'smooth',block:'start'});document.getElementById('loyalty-title').setAttribute('tabindex','-1');document.getElementById('loyalty-title').focus({preventScroll:true});}));
})();
