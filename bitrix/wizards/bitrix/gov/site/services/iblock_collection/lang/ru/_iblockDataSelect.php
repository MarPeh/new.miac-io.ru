<?
$heads       = '';
$heads_txt   = 'TEXTS_IBLOCK_ID';
$benefits    = '';
$documents   = '';
$gosserv     = '';
$massmedia   = '/about';
$newsRand    = 7;
$order       = '';
$rukovodstvo = '/about';
$vacancies   = '';
$visits      = '/about/visits';
$normative   = '/regulatory';
$regulatory  = '';

$wizard =& $this->GetWizard();
$suffix = substr($wizard->GetVar("typeID"), 5);

switch ($suffix) {
    case 'gd':
        $path = '/city';
        break;

    case 'mo':
        $path = '/city';
        break;

    case 'po':
        $path = '/region';
        break;

    case 'zso':
        $path    = '/region';
        $gosserv = '_' . $suffix;
        break;

    case 'prokuratura':
        $path        = '/city';
        $benefits    = '_no_doc';
        $rukovodstvo = '/city';
        $documents   = '_' . $suffix;
        $vacancies   = '_' . $suffix;
        $regulatory  = '_' . $suffix;
        break;
    case 'dep':
        $path      = '/about';
        $documents = '_' . $suffix;
        $newsRand  = 3;
        $order     = '/about';
        $visits    = '/exhibition/itogi';
        break;
    case 'progr':
        $path        = '/program';
        $order       = '/program';
        $rukovodstvo = '/program';
        $benefits    = '_no_doc';
        $documents   = '_' . $suffix;
        $massmedia   = '/program';
        break;

    case 'zags':
        $path      = '/info';
        $heads     = '/about';
        $order     = '/about';
        $heads_txt = 'demo_osov';
        $documents = '_' . $suffix;
        $vacancies = '_' . $suffix;
        $normative = '/about/documents';
        break;
    case 'pov':
        $path      = '/info';
        $documents = '_' . $suffix;
        $newsRand  = 3;
        $massmedia = '';
        $normative = '/about/regulatory';
        $order     = '/about';
        $visits    = '/exhibition/itogi';
        break;
}
?>