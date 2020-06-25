<?php if (Yii::$app->request->getUserIP() != '127.0.0.1'): ?>
<!— Global site tag (gtag.js) - Google Analytics —>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-140244918-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('set', {'user_id': <?=Yii::$app->user->isGuest?'false':Yii::$app->user->id?>});
    gtag('config', 'UA-140244918-1');
</script>
<?php endif?>