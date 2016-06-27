<?= $this->render_partial("container/_user_key.php") ?>

<div style="display: none;" id="encryption_error">
    <?= MessageBox::error(_("Das Dokument kann leider nicht entschlüsselt werden. Vermutlich muss es erst von jemand anderem erneut gespeichert werden, damit Sie das lesen können.")) ?>
</div>

<form action="<?= PluginEngine::getLink($plugin, array(), "container/store/".$container->getId()) ?>"
      method="post"
      class="default"
      id="content_form">

    <input type="text" name="name" value="<?= htmlReady($container['name']) ?>">

    <input type="hidden" name="encrypted_content" id="encrypted_content" value="<?= htmlReady($container['encrypted_content']) ?>">

    <input type="hidden" name="mime_type" value="text/plain">

    <textarea id="content"
              style="width: calc(100% - 20px); height: calc(100vh - 90px);"
              placeholder="<?= $container['encrypted_content'] ? _("Es wird entschlüsselt ...") : _("Text eingeben ...") ?>"></textarea>

    <script>
        STUDIP.Tresor.keyToEncryptFor = <?= json_encode(studip_utf8encode(array_map(
            function ($key) { return $key['public_key']; },
            $foreign_user_public_keys
        ))) ?>;
        jQuery(STUDIP.Tresor.decryptContainer);
    </script>

</form>


<div>
    <label>
        <input type="file" id="file_upload" onChange="STUDIP.Tresor.selectFile(event);">
        <?= _("Datei hochladen") ?>
    </label>
    <?= \Studip\LinkButton::create(_("Speichern"), "#", array('onClick' => "STUDIP.Tresor.storeContainer(); return false;")) ?>
</div>

