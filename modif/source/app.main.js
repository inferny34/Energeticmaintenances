(() => {
  'use strict';
  const config = window.EMS_CONFIG || {preview:true};
  const isPreview = config.preview !== false || !config.registrationEndpoint || !config.referralEndpoint;
  const $ = (s,root=document) => root.querySelector(s);
  const $$ = (s,root=document) => [...root.querySelectorAll(s)];
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const dialog = $('#contract-dialog');
  const contract = window.EMS_CONTRACT;
  let pageIndex = 0, lastFocus = null;

  function showPage(index) {
    if(!contract || !contract.pages.length) return;
    pageIndex = Math.max(0,Math.min(contract.pages.length-1,index));
    const page = contract.pages[pageIndex];
    const picture=$('#contract-page-image'),status=$('#reader-load-status');
    picture.hidden=true;
    status.hidden=false;status.textContent='Chargement de la page…';
    picture.onload=()=>{picture.hidden=false;status.hidden=true;};
    picture.onerror=()=>{picture.hidden=true;status.hidden=false;status.textContent='Cette page n’a pas pu être chargée. Utilisez les trois points pour télécharger le PDF complet.';};
    picture.src = page.image;
    $('#contract-page-image').alt = `Page ${pageIndex+1} du contrat EMS, version 8`;
    $('#contract-page-text').textContent = page.text;
    $('#reader-counter').textContent = `${pageIndex+1} / ${contract.pages.length}`;
    $('#reader-prev').disabled = pageIndex===0;
    $('#reader-next').disabled = pageIndex===contract.pages.length-1;
    $('#reader-menu').hidden = true;
    $('#reader-menu-button').setAttribute('aria-expanded','false');
  }
  function closeReader() { if(dialog.open) dialog.close(); }
  $$('[data-contract]').forEach(button => button.addEventListener('click',() => {
    lastFocus = button;
    if(!contract || !contract.pages.length) return;
    showPage(Number(button.dataset.contractPage || 0));
    dialog.showModal();
    document.body.style.overflow = 'hidden';
    $('#reader-close').focus();
  }));
  $('#reader-close').addEventListener('click',closeReader);
  dialog.addEventListener('close',() => {document.body.style.overflow='';lastFocus?.focus();});
  dialog.addEventListener('click',event => {if(event.target===dialog){const r=dialog.getBoundingClientRect();if(event.clientX<r.left||event.clientX>r.right||event.clientY<r.top||event.clientY>r.bottom)closeReader();}});
  $('#reader-prev').addEventListener('click',() => showPage(pageIndex-1));
  $('#reader-next').addEventListener('click',() => showPage(pageIndex+1));
  dialog.addEventListener('keydown',event => {
    if(event.key==='ArrowRight') {event.preventDefault();showPage(pageIndex+1);}
    if(event.key==='ArrowLeft') {event.preventDefault();showPage(pageIndex-1);}
  });
  $('#reader-menu-button').addEventListener('click',() => {
    const menu=$('#reader-menu');menu.hidden=!menu.hidden;
    $('#reader-menu-button').setAttribute('aria-expanded',String(!menu.hidden));
  });
  let touchStart=null;
  $('#reader-swipe').addEventListener('touchstart',event => {
    touchStart=event.touches.length===1 ? {x:event.touches[0].clientX,y:event.touches[0].clientY} : null;
  },{passive:true});
  $('#reader-swipe').addEventListener('touchend',event => {
    if(!touchStart || event.changedTouches.length!==1) return;
    const dx=event.changedTouches[0].clientX-touchStart.x,dy=event.changedTouches[0].clientY-touchStart.y;
    if((window.visualViewport?.scale||1)<=1.05) {
      if(Math.abs(dx)>45 && Math.abs(dx)>Math.abs(dy)*1.4) showPage(pageIndex+(dx<0?1:-1));
      else if(Math.abs(dy)>55 && Math.abs(dy)>Math.abs(dx)*1.4) showPage(pageIndex+(dy<0?1:-1));
    }
    touchStart=null;
  },{passive:true});

  function selectForm(kind,scroll=false) {
    const target=kind==='referral'?'referral':'registration';
    $$('[data-tab]').forEach(tab=>tab.setAttribute('aria-selected',String(tab.dataset.tab===target)));
    const pane=$('#registration-form'); if(scroll) pane.scrollIntoView({behavior:reduced?'auto':'smooth'});
    
    if(scroll) $('#formulaires').scrollIntoView({behavior:reduced?'auto':'smooth',block:'start'});
  }
  $$('[data-tab]').forEach(tab=>{
    tab.addEventListener('click',()=>selectForm(tab.dataset.tab));
    tab.addEventListener('keydown',event=>{
      if(['ArrowLeft','ArrowRight'].includes(event.key)){
        event.preventDefault();const other=tab.dataset.tab==='registration'?'referral':'registration';
        selectForm(other);$(`[data-tab="${other}"]`).focus();
      }
    });
  });
  $$('[data-form]').forEach(link=>link.addEventListener('click',event=>{event.preventDefault();selectForm(link.dataset.form,true);}));

  function updateConditions(form) {
    const profile=$('[name=profile]',form)?.value;
    const vat=$('[name=vat_regime]',form)?.value;
    const link=$('[name=professional_link]',form)?.value;
    const flags={professional:profile==='Professionnel',
      vat:profile==='Professionnel'&&vat==='TVA facturée',
      'vat-other':profile==='Professionnel'&&vat==='Autre',
      'linked-referral':form.id==='referral-form'&&link==='Oui'};
    $$('[data-condition]',form).forEach(group=>{const on=!!flags[group.dataset.condition];group.hidden=!on;group.disabled=!on;});
    const checks=$('[name=checks_completed]',form);if(checks)checks.setCustomValidity(checks.value==='Oui'?'':'Effectuez les vérifications requises avant d’envoyer votre demande.');
    const stop=$('.verification-stop',form);if(stop)stop.hidden=checks?.value!=='Non';
    const authorization=$('[name=employer_authorization]',form);if(authorization)authorization.required=link==='Oui'&&$('[name=authorization_status]',form)?.value==='Autorisation écrite jointe';
  }
  const today=new Date();
  const todayLocal=`${today.getFullYear()}-${String(today.getMonth()+1).padStart(2,'0')}-${String(today.getDate()).padStart(2,'0')}`;
  $$('[data-past-date]').forEach(input=>input.max=todayLocal);
  const zones=new Set(['07','11','12','13','30','31','34','48','66','81','83']);
  const postal=$('[name=postal_code]');
  postal.addEventListener('input',()=>{
    const code=postal.value.trim(),feedback=$('#zone-feedback');
    if(code.length!==5) {feedback.textContent='';return;}
    if(!zones.has(code.slice(0,2))) feedback.textContent='Ce chantier est hors de la zone prévue au contrat. Contactez EMS pour examiner la situation ; une présentation n’ouvre pas automatiquement droit à commission.';
    else feedback.textContent='Département dans la zone prévue. EMS examinera le projet avant toute acceptation.';
  });

  function setMessage(form,text,error=false) {
    const message=$('.ems-form-message',form);message.textContent=text;message.dataset.error=String(error);
  }
  function checkClientContact(form) {
    if(form.id!=='referral-form') return true;
    const phone=$('[name=client_phone]',form),email=$('[name=client_email]',form),method=$('[name=contact_method]',form).value;
    phone.setCustomValidity('');email.setCustomValidity('');
    if(!phone.value.trim()&&!email.value.trim()) phone.setCustomValidity('Indiquez au moins un moyen de contact du client.');
    if(['Téléphone','SMS'].includes(method)&&!phone.value.trim()) phone.setCustomValidity('Le téléphone est nécessaire pour le moyen de contact demandé.');
    if(method==='E-mail'&&!email.value.trim()) email.setCustomValidity('L’e-mail est nécessaire pour le moyen de contact demandé.');
    return form.reportValidity();
  }
  $$('form').forEach(form=>{
    updateConditions(form);
    form.addEventListener('change',()=>updateConditions(form));
    form.addEventListener('input',()=>{
      updateConditions(form);
      delete form.dataset.submissionId;
      $$('[name=client_phone],[name=client_email]',form).forEach(input=>input.setCustomValidity(''));
      if(form.dataset.sent==='true') {
        delete form.dataset.sent;delete form.dataset.submissionId;
        $('button[type=submit]',form).disabled=false;
      }
    });
    form.addEventListener('submit',async event=>{
      event.preventDefault();
      updateConditions(form);
      if($('[name=checks_completed]',form)?.value!=='Oui'){setMessage(form,'Effectuez les vérifications requises et complétez votre dossier avant de l’envoyer.',true);form.reportValidity();return;}
      if(!checkClientContact(form)||!form.reportValidity()) return;
      if(form.id==='registration-form' && ['rib','registration_proof','vigilance_proof','vat_proof'].some(name=>!$(`[name=${name}]`,form).files.length)){setMessage(form,'Joignez les quatre pièces obligatoires pour envoyer votre dossier.',true);return;}
      const files=$$('input[type=file]',form).filter(input=>!input.disabled&&!input.closest('fieldset[disabled]')).flatMap(input=>[...input.files]);
      if(files.some(file=>file.size>(config.maxFileBytes||10485760))) {
        setMessage(form,'Une pièce dépasse la taille autorisée de 10 Mo. Réduisez-la ou transmettez-la séparément à EMS.',true);return;
      }
      const endpoint=form.id==='registration-form'?config.registrationEndpoint:config.referralEndpoint;
      if(isPreview||!endpoint) {
        setMessage(form,'Aperçu : les champs sont valides, mais aucune information ni pièce jointe n’a été envoyée. Le raccordement sera activé lors de l’intégration sur le site.');return;
      }
      let url;
      try {url=new URL(endpoint,window.location.href);if(url.origin!==window.location.origin||url.protocol!=='https:')throw new Error('Configuration');}
      catch (_) {setMessage(form,'Le formulaire n’est pas disponible. Contactez EMS directement.',true);return;}
      const button=$('button[type=submit]',form);button.disabled=true;button.setAttribute('aria-busy','true');
      setMessage(form,'Transmission en cours…');
      if(!form.dataset.submissionId) form.dataset.submissionId=window.crypto?.randomUUID?.()||`request-${Date.now()}-${Math.random().toString(36).slice(2)}`;
      const data=new FormData(form);data.set('submission_id',form.dataset.submissionId);data.set('model_version','V8');data.set('form_version','EMS-WEB-PRO-CONTRAT-8');
      const csrf=$('meta[name=csrf-token]')?.content;
      try {
        const response=await fetch(url.href,{method:'POST',body:data,credentials:'same-origin',headers:csrf?{'X-CSRF-Token':csrf}:{}});
        const result=await response.json();
        if(!response.ok||result.success!==true||typeof result.receipt_id!=='string'||!result.receipt_id.trim())throw new Error('Transmission non confirmée');
        form.dataset.sent='true';
        setMessage(form,form.id==='registration-form'
          ?`Votre demande a été transmise à EMS. Référence : ${result.receipt_id}. EMS examinera vos informations pour préparer le contrat. Aucune signature n’a été effectuée.`
          :`Votre présentation a été transmise à EMS. Référence : ${result.receipt_id}. Conservez cette référence ; la réponse d’EMS vous sera adressée par écrit. La transmission ne vaut pas acceptation.`);
      } catch (_) {
        setMessage(form,'La réception par EMS n’a pas pu être confirmée. Ne considérez pas la demande comme acceptée ; contactez EMS ou réessayez. Vos champs restent affichés.',true);
      } finally {button.disabled=form.dataset.sent==='true';button.removeAttribute('aria-busy');}
    });
  });
  if(!isPreview) $('#preview-notice').hidden=true;
  $$('a[href="mentions-legales.html"]').forEach(a=>a.href=config.legalNoticeUrl||'mentions-legales.html');
  $$('a[href="politique-confidentialite.html"]').forEach(a=>a.href=config.privacyUrl||'politique-confidentialite.html');
})();
