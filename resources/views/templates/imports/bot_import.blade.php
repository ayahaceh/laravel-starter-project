{{-- Jquery --}}
<script src="{{asset('assets/vendors/jquery/jquery.min.js')}}"></script>

{{-- Scroll JS --}}
<script src="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

{{-- DataTable --}}
<script src="{{asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js')}}"></script>

{{-- Choices Select (Select2) --}}
<script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>

{{-- Font Awesome 5 --}}
<script src="{{asset('assets/vendors/fontawesome/all.min.js')}}"></script>

{{-- Jquery Validation --}}
<script src="{{asset('assets/js/third_party/jquery_validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/js/third_party/jquery_validation/additional-methods.js')}}"></script>

{{-- Core Template --}}
<script src="{{asset('assets/js/mazer.js')}}"></script>

{{-- Custom File --}}

<script type="text/javascript">

    $(document).ready(function(e){
        /// Initialize Select Choices Plugin
        initSelectChoices();

        /// Initialize Jquery Validation Configuration
        initJqueryValidation();

        /// Set Default Toggle Filter Content to hidden
        $(".toggle-more-filter-content").hide();

        $(".toggle-more-filter").on('click',function(e){
            let child = $(this).children();
            let isPlusIcon = child.hasClass('fa-plus');
            if(isPlusIcon)  child.removeClass('fa-plus').addClass('fa-minus');
            else child.removeClass('fa-minus').addClass('fa-plus');

            /// Toggle Filter Content
            $(".toggle-more-filter-content").toggle('fast');
        });
    });

    // [https://stackoverflow.com/questions/28948383/how-to-implement-debounce-fn-into-jquery-keyup-event
    // [http://davidwalsh.name/javascript-debounce-function]
    function debounce(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            const later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    function openBox(
        /// Url is mandatory
        url ="zeffry.dev",
        {

        /// [modal-sm, modal-md, modal-lg, modal-xl, modal-full]
        size = "",

        /// Make modal header dont have border bottom
        borderlessModal = false,

        /// Make modal center of screen
        verticalCentered = true,

        /// Make body of modal scrollable if content is long
        modalScrollable = true,

    } = {}){
        let modal = $("#modal-default");
        let modalDialog = modal.children();

        if(borderlessModal) modal.addClass('modal-borderless');

        if(size.length !== 0 ) modalDialog.addClass(size);

        if(verticalCentered) modalDialog.addClass('modal-dialog-centered');

        if(modalScrollable) modalDialog.addClass('modal-dialog-scrollable');

        /// Open Modal
        modal.modal('show');

        $.get(url,function(data,status,xhr){
            $(".modal-content").html(data);
        });
    }

    /// Initialize Select Choices Plugin
    function initSelectChoices(){
        let choices = document.querySelectorAll('.choices');
        let initChoice;
        for(let i=0; i<choices.length;i++) {
            if (choices[i].classList.contains("multiple-remove")) {
                initChoice = new Choices(choices[i],
                {
                    delimiter: ',',
                    editItems: true,
                    maxItemCount: -1,
                    removeItemButton: true,
                });
            }else{
                initChoice = new Choices(choices[i]);
            }
        }
    }

    /// Initialize Jquery Validation Configuration Global
    /// Available Rules Except :
    /// Because this validation already nice built in HTML5
    /// a. required
    /// b. min
    /// c. max
    /// d. minlength
    /// e. maxlength
    /// f. email
    /// g. url
    /// h. number

    /// Available :
    /// 1. rangelength => rangelength : [5 (min), 10 (max)] Input length should be in range 5 - 10.
    /// Example : ABCDE(VALID) || ABCD (NOT VALID because only have 4 length)
    /// 2. range => range : [10 (mix), 20 (max)] Input value should be range 10 - 20.
    /// Example : 5 (NOT VALID) || 15 (VALID)
    /// 3. step => step : 10 Make input value should be multiple of 10.
    /// Example : 5 (NOT VALID) || 50 (VALID)
    /// 3. equalTo => equalTo : "#password" Make input value must be equal with reference input
    /// Example : password_again { equalTo : "#password"}
    /// 4. accept => accept : "image/*, application/pdf" input only can image or pdf.
    /// Example => accept : "image/*, application/pdf"

    /// Additional Method Jquery usefull [https://github.com/jquery-validation/jquery-validation/tree/master/src/additional]
    function initJqueryValidation(){
        $.validator.setDefaults({
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                // Add the `invalid-feedback` class to the error element
                error.addClass( "invalid-feedback" );

                if ( element.prop( "type" ) === "checkbox" ) {
                    error.insertAfter( element.next( "label" ) );
                } else {
                    error.insertAfter( element );
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            }
        });
    }
</script>
