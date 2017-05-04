// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");


// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
    } else {
        mySidebar.style.display = 'block';
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}

$.fn.modal.Constructor.prototype.enforceFocus = function() {
    modal_this = this
    $(document).on('focusin.modal', function (e) {
        if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
            && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select')
            && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
            modal_this.$element.focus()
        }
    })
};

toastr.options = {
    "positionClass": "toast-bottom-left",
    "preventDuplicates": true,
};

$('input[type="text"]')
    .on('invalid', function(){
        return this.setCustomValidity('Vui lòng nhập thông tin.');
    })
    .on('input', function(){
        return this.setCustomValidity('');
    });

$('input[type="email"]')
    .on('invalid', function(){
        return this.setCustomValidity('Vui lòng nhập Email.');
    })
    .on('input', function(){
        return this.setCustomValidity('');
    });

$('input[type="number"]')
    .on('invalid', function(){
        return this.setCustomValidity('Vui lòng nhập số');
    })
    .on('input', function(){
        return this.setCustomValidity('');
    });
