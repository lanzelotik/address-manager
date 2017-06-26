<?php if (!empty($addresses)): ?>
    <h4>Addresses:</h4>
    <table class="addresses">
        <?php foreach ($addresses as $address): ?>
            <tr class="address-item <?= ($address->default == Address::IS_DEFAULT ? 'default' : '') ?>">
                <td>
                    <?= $address->street_number ?> <?= $address->route ?>, <?= $address->city ?><br/>
                    <?= $address->state ?>, <?= $address->zip ?>
                </td>
                <td>
                    <?= CHtml::link('Delete', '#', array(
                        'class' => 'delete-link',
                        'data-href' => CHtml::normalizeUrl(array($baseUrl . 'delete', 'id' => $address->id)),
                    )); ?>
                </td>
                <td>
                    <?php if ($address->default != Address::IS_DEFAULT): ?>
                        <?= CHtml::link('Make default', '#', array(
                            'class' => 'make-default-link',
                            'data-href' => CHtml::normalizeUrl(array($baseUrl . 'makeDefault', 'id' => $address->id)),
                        )); ?>
                    <?php else: ?>
                        (default)
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif; ?>