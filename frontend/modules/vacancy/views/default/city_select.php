<select class="vl-block__cities jsCitiesSelect">
    <option></option>
    <?php if($cities): ?>
        <?php foreach($cities as $city):?>
            <option value="<?=$city->slug?>"><?=$city->name?></option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>