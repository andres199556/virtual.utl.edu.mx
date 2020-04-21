<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="../assets/plugins/popper/popper.min.js"></script>
<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="../material/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="../material/js/waves.js"></script>
<!--Menu sidebar -->
<script src="../material/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!--Custom JavaScript -->
<script src="../material/js/custom.min.js"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
<script src="../assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="../assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script src="../assets/plugins/alert2/sweetalert2.all.js"></script>


<script src="../assets/plugins/toast-master/js/jquery.toast.js"></script>


<script src="../assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="../assets/plugins/dropify/dist/js/dropify.min.js"></script>



<script src="../assets/plugins/datatables/datatables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script> -->
<script src="../assets/plugins/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
<script src="../assets/plugins/bootstrap-datepicker/locales/es.js"></script>
<script src="../assets/plugins/switchery/dist/switchery.min.js"></script>
<script src="../assets/plugins/moment/moment.js"></script>

<script src="../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="../assets/plugins/alertifyjs/alertify.js"></script>

<script>
$("#id_modulo_dashboard").select2();

function cambiar_modulo(ruta) {
    window.location = ruta;
}
// Switchery
$('.js-switch').each(function() {
    new Switchery($(this)[0], $(this).data());
});
</script>