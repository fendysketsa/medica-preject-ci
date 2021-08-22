<?php if (!empty($css)) {
    foreach ($css as $css_) { ?>
        <link rel="stylesheet" href="<?php echo base_url($css_); ?>">
<?php }
} ?>

<style>
    .bg-red {
        background-color: #c00000 !important;
        color: #fff;
    }

    #chart_pie_compo {
        margin: 0 auto;
        display: table;
        margin-top: 75px;
    }

    .table-performa {
        border: 2px solid !important;
        width: 100%;
    }

    .table-performa th {
        font-size: 15px;
        text-align: center;
        font-weight: bold;
    }

    .table-performa td {
        font-size: 13px;
        font-weight: bold;
    }

    .size-15 {
        font-size: 15px;
        font-weight: bold;
    }

    .m-t-2 {
        margin-top: -5px;
        margin-bottom: -20px;
    }

    .m-t-2 h4 {
        font-size: 15px;
        font-weight: bold;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h2><em class="glyphicon glyphicon-signal"></em> Dashboard</h2>
            <hr>
            <div class="card">
                
            </div>
        </div>
    </div>
    