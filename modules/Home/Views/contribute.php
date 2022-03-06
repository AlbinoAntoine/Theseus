<?= $this->extend('Modules\Commun\Views\layouts\general_public') ?>

<?= $this->section('content') ?>

<main class="container">

    <h1 class="mt-4">Contribute at Theseus</h1>
    <p>You find the project interesting and you want to help it develop and improve?</p>
    <form action="https://www.paypal.com/donate" method="post" target="_top" class="">
        <input type="hidden" name="hosted_button_id" value="PCJGEUCUEXRRU" />
        <input type="image" src="https://www.paypalobjects.com/en_US/FR/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
        <img alt="" border="0" src="https://www.paypal.com/en_FR/i/scr/pixel.gif" width="1" height="1" />
    </form>

</main>


<?= $this->endSection() ?>
