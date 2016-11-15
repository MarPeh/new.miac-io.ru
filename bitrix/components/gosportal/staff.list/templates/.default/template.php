<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="content">
	<div class="col col-mb-12 col-dt-11">
    <?
    $arDeptsChain = array();
    $arCurrentDepth = array();
    $arUsers = array();
    if (is_array($arResult['DEPARTMENTS'])) {
        foreach ($arResult['DEPARTMENTS'] as $arDept) {
        ?>
            <h2><? echo $arDept["NAME"] ?></h2><hr>
            <?
            if (count($arDept['USERS']) > 0) {
            ?>
                <? foreach ($arDept['USERS'] as $arUser) { ?>
                    <? if ($arUser['NAME'] == '' || in_array($arUser['ID'], $arUsers)) continue; ?>
                    <? $arUsers[] = $arUser['ID'] ?>
                        <div class="teachers-item col-margin-bottom">
                            <div class="content">
                                <div class="col col mb-12 col-4">
                    <? if (is_array($arUser['PERSONAL_PHOTO'])) { ?>
                                    <img src="<?= $arUser['PERSONAL_PHOTO']['SRC'] ?>" width="<?= $arUser['PERSONAL_PHOTO']['WIDTH'] ?>" height="<?= $arUser['PERSONAL_PHOTO']['HEIGHT'] ?>" alt="<?= $arUser['LAST_NAME'] ?> <?= $arUser['NAME'] ?> <?= $arUser['SECOND_NAME'] ?>">
                    <? } else { ?>
                                    <img src="<?= SITE_TEMPLATE_PATH ?>/images/collectiv_img_no_<?= ($arUser["PERSONAL_GENDER"] == "F" ? "women" : "men") ?>.jpg" alt="<?= $arUser['LAST_NAME'] ?> <?= $arUser['NAME'] ?> <?= $arUser['SECOND_NAME'] ?>">
                    <? } ?>
                                </div>
                                <div class="col col-mb-12 col-8">
                                    <h2 class="mt0">
                                        <a href="<?= str_replace('#ELEMENT_ID#', $arUser['ID'], $arParams['DETAIL_URL']) ?>">
                    <?= $arUser['LAST_NAME'] ?> <?= $arUser['NAME'] ?> <?= $arUser['SECOND_NAME'] ?>
                                        </a>
                                    </h2>
                    <? if (!empty($arUser['WORK_POSITION'])) { ?><p class="fz18"><?= $arUser['WORK_POSITION'] ?></p><? } ?>
                                    <div class="text-light">
                    <? if (!empty($arUser['PERSONAL_MOBILE'])) { ?><div><?= $arUser['PERSONAL_MOBILE'] ?></div><? } ?>
                    <? if (!empty($arUser['EMAIL'])) { ?><div><?= $arUser['EMAIL'] ?></div><? } ?>
                    <? if (!empty($arUser['PERSONAL_WWW'])) { ?><div><? echo $arUser['PERSONAL_WWW'] ?></div><? } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?
                }
            }
        }
    }
?>
	</div>
</div>