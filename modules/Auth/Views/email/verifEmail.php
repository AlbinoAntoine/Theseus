<p>
Hello <?=$Prenom?>, you have created an account on <a href="<?=site_url()?>">Theseus</a>
</p>
<p>
    <a href="<?=site_url('valide_email/'.$secret_code)?>">Click here to validate your email</a>
</p>
<p>If it's not you, ignore this email or click <a href="<?=site_url('delete_email/'.$secret_code)?>">here</a> to remove your Email from our database</p>