<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            ©

            , made with ❤️ by
            <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
        </div>
        <div>
            <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
            <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

            <a
                href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                target="_blank"
                class="footer-link me-4"
            >Documentation</a
            >

            <a
                href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                target="_blank"
                class="footer-link me-4"
            >Support</a
            >
        </div>
    </div>
</footer>

<div class="modal fade" id="modalid" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2"></h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>


<style>
.form-check {
    margin: 10px  !important;
    padding-top: 30px  !important;
}
@media (min-width: 576px)
    .col-sm-12 {
        margin: auto !important;
    }
</style>




<!-- / Footer -->
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{asset('assets/backend/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('assets/backend/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

<script src="{{asset('assets/backend/vendor/js/menu.js')}}"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="{{asset('assets/backend/js/main.js')}}"></script>

<!-- Page JS -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {

        $('body').on('click', '.modals', function (event) {
            event.preventDefault();

            var url = $(this).attr('data-href');
            $.ajax({
                url: url,
                dataType: 'json',
                beforeSend: function () {
                    $('body').addClass('loader');
                },
                complete: function () {
                    $('body').removeClass('loader');
                },
                success: function (json) {
                    if (json['success'] && json['html']) {
                        $('#modalid').modal('show');
                        $('#modalid .modal-title').html(json['title']);
                        $('#modalid .modal-body').append(json['html']);
                    }
                    if (json['error']) {
                        $("#modalid").removeClass('show');
                    }
                },
                error: function (xhr) {
                    $("#modalid").removeClass('show');
                }
            });
        });

        $("#modalid").delegate('.btn-close', 'click', function () {
            $("#modalid").removeClass('show');
            $("#modalid .modal-body").html('');
        });
    });
    $(document).ready(function () {
        if ($(".js-example-basic-multiple").length > 0) {
            $('.js-example-basic-multiple').select2();
        }
    })

</script>


