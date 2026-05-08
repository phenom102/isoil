<?php
$yesterday = date("d-m-Y",strtotime("-1 days"));
$serverName = "192.168.0.7";
$connectionOptions = [
    "Database"=>"ISOIL",
    "Uid"=>"sa",
    "PWD"=>"Lora2022@1%"
];
$conn = sqlsrv_connect($serverName, $connectionOptions);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <title>Dashboard - ISOIL</title>

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- DEMO ONLY: Function for the proper stylesheet loading according to the demo settings -->
    <script>function _pxDemo_loadStylesheet(a,b,c){var c=c||decodeURIComponent((new RegExp(";\\s*"+encodeURIComponent("px-demo-theme")+"\\s*=\\s*([^;]+)\\s*;","g").exec(";"+document.cookie+";")||[])[1]||"clean"),d="rtl"===document.getElementsByTagName("html")[0].getAttribute("dir");document.write(a.replace(/^(.*?)((?:\.min)?\.css)$/,'<link href="$1'+(c.indexOf("dark")!==-1&&a.indexOf("/css/")!==-1&&a.indexOf("/themes/")===-1?"-dark":"")+(!d||0!==a.indexOf("assets/css")&&0!==a.indexOf("assets/demo")?"":".rtl")+'$2" rel="stylesheet" type="text/css"'+(b?'class="'+b+'"':"")+">"))}</script>

    <!-- DEMO ONLY: Set RTL direction -->
    <script>"ltr"!==document.getElementsByTagName("html")[0].getAttribute("dir")&&"1"===decodeURIComponent((new RegExp(";\\s*"+encodeURIComponent("px-demo-rtl")+"\\s*=\\s*([^;]+)\\s*;","g").exec(";"+document.cookie+";")||[])[1]||"0")&&document.getElementsByTagName("html")[0].setAttribute("dir","rtl");</script>

    <!-- DEMO ONLY: Load PixelAdmin core stylesheets -->
    <script>
        _pxDemo_loadStylesheet('assets/css/bootstrap.min.css', 'px-demo-stylesheet-bs');
        _pxDemo_loadStylesheet('assets/css/pixeladmin.min.css', 'px-demo-stylesheet-core');
        _pxDemo_loadStylesheet('assets/css/widgets.min.css', 'px-demo-stylesheet-widgets');
    </script>

    <!-- DEMO ONLY: Load theme -->
    <script>
        function _pxDemo_loadTheme(a){var b=decodeURIComponent((new RegExp(";\\s*"+encodeURIComponent("px-demo-theme")+"\\s*=\\s*([^;]+)\\s*;","g").exec(";"+document.cookie+";")||[])[1]||"clean");_pxDemo_loadStylesheet(a+b+".min.css","px-demo-stylesheet-theme",b)}
        _pxDemo_loadTheme('assets/css/themes/');
    </script>

    <!-- Demo assets -->
    <script>_pxDemo_loadStylesheet('assets/demo/demo.css');</script>
    <!-- / Demo assets -->

    <!-- holder.js -->
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/holder/2.9.0/holder.js"></script>

    <!-- Pace.js -->
    <script src="assets/pace/pace.min.js"></script>

    <script src="assets/demo/demo.js"></script>

    <!-- Custom styling -->
    <style>
        .page-header-form .input-group-addon,
        .page-header-form .form-control {
            background: rgba(0,0,0,.05);
        }
    </style>
    <!-- / Custom styling -->
</head>
<body>
<nav class="px-nav px-nav-left">
    <button type="button" class="px-nav-toggle" data-toggle="px-nav">
        <span class="px-nav-toggle-arrow"></span>
        <span class="navbar-toggle-icon"></span>
        <span class="px-nav-toggle-label font-size-11">HIDE MENU</span>
    </button>

    <ul class="px-nav-content">
        <li class="px-nav-box b-t-1 p-a-2">
            <a href="index.php" class="btn btn-primary btn-block btn-outline"><i class="px-nav-icon ion-ios-pulse-strong"></i>Dashboard ISOIL</a>
        </li>
        <li class="px-nav-box b-t-1 p-a-2">
            <a href="ricerca.php" class="btn btn-primary btn-block btn-outline"><i class="px-nav-icon ion-ios-search"></i>Ricerca ISOIL</a>
        </li>
        <li class="px-nav-box b-t-1 p-a-2">
            <a href="portate.php" class="btn btn-primary btn-block btn-outline"><i class="px-nav-icon fa fa-tint"></i>Portate Telecontrollo</a>
        </li>
        <li class="px-nav-box b-t-1 p-a-2">
            <a href="portate_map.php" class="btn btn-primary btn-block btn-outline"><i class="px-nav-icon fa fa-map"></i>Portate Tel. Mappa</a>
        </li>
    </ul>
</nav>

<nav class="navbar px-navbar">
    <!-- Header -->
    <div class="navbar-header">
        <a class="navbar-brand px-demo-brand" href="index.php"><span class="px-demo-logo bg-primary"><span class="px-demo-logo-1"></span><span class="px-demo-logo-2"></span><span class="px-demo-logo-3"></span><span class="px-demo-logo-4"></span><span class="px-demo-logo-5"></span><span class="px-demo-logo-6"></span><span class="px-demo-logo-7"></span><span class="px-demo-logo-8"></span><span class="px-demo-logo-9"></span></span>ISOIL</a>
    </div>
</nav>

<div class="px-content">
    <div class="page-header">
        <div class="row">
            <div class="col-md-4 text-xs-center text-md-left text-nowrap">
                <h1><i class="page-header-icon ion-ios-search"></i>Ricerca</h1>
            </div>

            <hr class="page-wide-block visible-xs visible-sm">

            <!-- Spacer -->
            <div class="m-b-2 visible-xs visible-sm clearfix"></div>

        </div>
    </div>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Ricerca per data</span>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="result.php" method="get">
                <div class="col-sm-2">
                    <fieldset class="form-group">
                        <input type="text" name="ricerca-data" id="daterange-3" value="" class="form-control">
                    </fieldset>
                </div>
                <div class="col-sm-2">
                    <div class="col-sm-offset-1 col-sm-9">
                        <input type="submit" class="btn btn-primary" value="Ricerca">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Ricerca per dispositivo</span>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="result_dispositivo.php" method="get">
                <div class="col-sm-10">
                    <select name="dispositivo" class="form-control select2-example" style="width: 100%" data-allow-clear="true">
                            <option></option>
                            <?php
                                $sql = "SELECT * FROM RTU ORDER BY NOME ASC ";
                                $stmt = sqlsrv_query( $conn, $sql );
                                if( $stmt === false) {
                                    die( print_r( sqlsrv_errors(), true) );
                                }
                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                    echo "<option value='".$row['ID']."'>".$row['NOME']." - ".$row['POD']." - MATR:".$row['MATRICOLA']." - ID:".$row['ID']." - RTU:".$row['RTU'];
                                }
                            ?>
                        </select>
                </div>
                <div class="col-sm-2">
                    <div class="col-sm-offset-1 col-sm-9">
                        <input type="submit" class="btn btn-primary" value="Ricerca">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<footer class="px-footer px-footer-bottom p-t-0">
    <hr class="page-wide-block">

    <span class="text-muted">Copyright © 2026 CED Asis Salernitana reti ed impianti. Tutti i diritti riservati.</span>
</footer>

<!-- ==============================================================================
|
|  SCRIPTS
|
=============================================================================== -->

<!-- jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/pixeladmin.min.js"></script>
<script>
    // -------------------------------------------------------------------------
    // Initialize DataTables

    $(function() {
        $('#datatables').dataTable();
        $('#datatables_wrapper .table-caption').text('Uploads');
        $('#datatables_wrapper .dataTables_filter input').attr('placeholder', 'Cerca...');
    });
</script>

<script>
    // -------------------------------------------------------------------------
    // Initialize validation example

    $(function() {
        // Initialize Select2 select box
        $('#validation-select2').select2({
            allowClear:  true,
            placeholder: 'Select a framework...',
        }).change(function() {
            $(this).valid();
        });

        // Initialize Select2 multiselect box
        $('#validation-select2-multi').select2({
            placeholder: 'Select gear...',
        }).change(function() {
            $(this).valid();
        });

        // Initialize custom file input
        $('#validation-file-custom-label').pxFile();

        // Add phone validator
        $.validator.addMethod(
            'phone_format',
            function(value, element) {
                return this.optional(element) || /^\(\d{3}\)[ ]\d{3}\-\d{4}$/.test(value);
            },
            'Invalid phone number.'
        );

        // Initialize validator
        $('#validation-form').pxValidate({
            ignore: '.ignore, .select2-input',
            focusInvalid: false,
            rules: {
                'validation-email': {
                    required: true,
                    email: true
                },
                'validation-password': {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                'validation-password-confirmation': {
                    required: true,
                    minlength: 6,
                    equalTo: '#validation-password'
                },
                'validation-required': {
                    required: true
                },
                'validation-url': {
                    required: true,
                    url: true
                },
                'validation-phone': {
                    required: true,
                    phone_format: true
                },
                'validation-select': {
                    required: true
                },
                'validation-multiselect': {
                    required: true,
                    minlength: 2
                },
                'validation-select2': {
                    required: true
                },
                'validation-select2-multi': {
                    required: true,
                    minlength: 2
                },
                'validation-text': {
                    required: true
                },
                'validation-message-light': {
                    required: true
                },
                'validation-message-dark': {
                    required: true
                },
                'validation-file': {
                    required: true
                },
                'validation-file-custom': {
                    required: true
                },
                'validation-switcher': {
                    required: true
                },
                'validation-radios': {
                    required: true
                },
                'validation-radios-custom': {
                    required: true
                },
                'validation-checkbox': {
                    required: true
                },
                'validation-checkbox-custom': {
                    required: true
                },

                // Checkbox groups
                //

                'validation-checkbox-group-1': {
                    require_from_group: [1, 'input[name="validation-checkbox-group-1"], input[name="validation-checkbox-group-2"]']
                },
                'validation-checkbox-group-2': {
                    require_from_group: [1, 'input[name="validation-checkbox-group-1"], input[name="validation-checkbox-group-2"]']
                },

                'validation-checkbox-custom-group-1': {
                    require_from_group: [1, 'input[name="validation-checkbox-custom-group-1"], input[name="validation-checkbox-custom-group-2"]']
                },
                'validation-checkbox-custom-group-2': {
                    require_from_group: [1, 'input[name="validation-checkbox-custom-group-1"], input[name="validation-checkbox-custom-group-2"]']
                },
            },
        });
    });

    // -------------------------------------------------------------------------
    // Initialize wizard validation example

    $(function() {
        var $wizard = $('#wizard-validation');

        $wizard.pxWizard();

        // Init plugins
        $('#wizard-country').select2({
            placeholder: 'Select your country...'
        }).change(function() { $(this).valid(); });
        $('#wizard-postal-code').mask("999999");
        $('#wizard-credit-card-number').mask("9999 9999 9999 9999");
        $('#wizard-csv').mask("999");
        $('[data-toggle="tooltip"]').tooltip();

        // Rules

        $('#wizard-account').pxValidate({
            ignore: '.ignore',
            focusInvalid: false,
            rules: {
                'wizard-username': {
                    required:  true,
                    minlength: 3,
                    maxlength: 20,
                },
                'wizard-password': {
                    required:  true,
                    minlength: 6,
                    maxlength: 20,
                },
                'wizard-repeat-password': {
                    required:  true,
                    minlength: 6,
                    equalTo:   'input[name="wizard-password"]',
                },
                'wizard-email': {
                    required: true,
                    email:    true,
                },
            },
        });

        $("#wizard-profile").pxValidate({
            ignore: '.ignore, .select2-input',
            focusInvalid: true,
            rules: {
                'wizard-full-name': {
                    required: true,
                },
                'wizard-country': {
                    required: true,
                },
                'wizard-gender': {
                    required: true,
                },
            },
        });

        $("#wizard-credit-card").pxValidate({
            ignore: '.ignore',
            focusInvalid: true,
            rules: {
                'wizard-postal-code': {
                    required:    true,
                    digits:      true,
                    rangelength: [6, 6],
                },
                'wizard-credit-card-number': {
                    required:   true,
                    creditcard: true,
                },
                'wizard-csv': {
                    required:    true,
                    digits:      true,
                    rangelength: [3, 3],
                },
            },
        });

        // Validate

        $wizard.on('stepchange.px.wizard', function(e, data) {
            // Validate only if jump to the forward step
            if (data.nextStepIndex < data.activeStepIndex) { return; }

            var $form = $wizard.pxWizard('getActivePane');

            if (!$form.valid()) {
                e.preventDefault();
            }
        });

        // Finish

        $wizard.on('finished.px.wizard', function() {
            //
            // Collect and send data...
            //

            $('#wizard-finish').find('.ion-checkmark-round').removeClass('ion-checkmark-round').addClass('ion-checkmark-circled');
            $('#wizard-finish').find('h4').text('Thank You!');
            $('#wizard-finish').find('button').remove();
        });

    });
</script>

<script>
    // -------------------------------------------------------------------------
    // Initialize Date Range Picker

    $(function() {
        $('#daterange-1').daterangepicker();

        $('#daterange-2').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'DD/MM/YYYY h:mm A'
            }
        });

        $('#daterange-3').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY',
                    "daysOfWeek": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mer",
                        "Gio",
                        "Ven",
                        "Sab"
                    ],
                    "monthNames": [
                        "Gennaio",
                        "Febbraio",
                        "Marzo",
                        "Aprile",
                        "Maggio",
                        "Giugno",
                        "Luglio",
                        "Agosto",
                        "Settembre",
                        "Ottobre",
                        "Novembre",
                        "Dicembre"
                    ],
                    "firstDay": 1
                },
                maxDate: moment().endOf("day"),
                singleDatePicker: true,
                showDropdowns: true
            });

        (function() {
            var startDate = moment().subtract(29, 'days');
            var endDate = moment();

            function cb(start, end) {
                $('#daterange-4').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#daterange-4').daterangepicker({
                startDate: startDate,
                endDate: endDate,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(startDate, endDate);
        })();
    });

    // -------------------------------------------------------------------------
    // Initialize Datepicker

    $(function() {
        $('#datepicker-features').datepicker({
            calendarWeeks:         true,
            todayBtn:              'linked',
            daysOfWeekDisabled:    '1',
            clearBtn:              true,
            todayHighlight:        true,
            multidate:             true,
            daysOfWeekHighlighted: '1,2',
            orientation:           'auto right',

            beforeShowMonth: function(date) {
                if (date.getMonth() === 8) {
                    return false;
                }
            },

            beforeShowYear: function(date){
                if (date.getFullYear() === 2014) {
                    return false;
                }
            }
        });
        $('#datepicker-range').datepicker();
        $('#datepicker-inline').datepicker();
    });

    // -------------------------------------------------------------------------
    // Initialize Timepicker

    $(function() {
        $('#timepicker-base').timepicker();
        $('#timepicker-features').timepicker();
        $('#timepicker-addon').timepicker();
        $('#timepicker-modal').timepicker();
    });

    // -------------------------------------------------------------------------
    // Initialize Minicolors

    $(function() {
        $('#minicolors-hue').minicolors({
            control:  'hue',
            position: 'bottom left',
        });

        $('#minicolors-saturation').minicolors({
            control:  'saturation',
            position: 'bottom right',
        });

        $('#minicolors-wheel').minicolors({
            control:  'wheel',
            position: 'top right',
        });

        $('#minicolors-opacity').minicolors({
            control: 'wheel',
            opacity: true,
        });

        $('#minicolors-brightness').minicolors({
            control:  'brightness',
            position: 'top left',
        });

        $('#minicolors-hidden').minicolors();

        $('#minicolors-sm-left').minicolors({
            opacity: true,
        });

        $('#minicolors-sm-right').minicolors({
            opacity:  true,
            position: 'top right',
        });

        $('#minicolors-sm-hidden').minicolors();

        $('#minicolors-lg-left').minicolors({
            opacity: true,
        });

        $('#minicolors-lg-right').minicolors({
            opacity:  true,
            position: 'top right',
        });

        $('#minicolors-lg-hidden').minicolors();
    });

    $(function() {
        if (window.skipQuickSelect) {
            $('<div class="alert alert-warning">Quick[select] doesn\'t support Internet Explorer 9</div>').insertBefore('#quick-select-1');
            return;
        }

        $('#quick-select-1').quickselect({
            activeButtonClass: 'btn-primary active',
            breakOutValues: ['Breakfast', 'Lunch', 'Dinner'],
            buttonClass: 'btn btn-default',
            selectDefaultText: 'Other',
            wrapperClass: 'btn-group'
        });

        $('#quick-select-2').quickselect({
            activeButtonClass: 'btn-primary active',
            breakOutAll: true,
            buttonClass: 'btn btn-default',
            selectDefaultText: 'Other',
            wrapperClass: 'btn-group'
        });

        $('#quick-select-3').quickselect({
            activeButtonClass: 'btn-primary active',
            breakOutValues: ['Breakfast', 'Lunch', 'Dinner'],
            buttonClass: 'btn btn-default',
            selectDefaultText: 'Other',
            wrapperClass: 'btn-group'
        });
    });
</script>


</body>
</html>
