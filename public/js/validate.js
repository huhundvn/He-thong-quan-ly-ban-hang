/**
 * Created by Good on 3/26/2017.
 */
$('input[type="text"]')
    .on('invalid', function(){
        return this.setCustomValidity('Vui lòng nhập thông tin');
    })
    .on('input', function(){
        return this.setCustomValidity('');
    });

$('input[type="email"]')
    .on('invalid', function(){
        return this.setCustomValidity('Email không đúng');
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