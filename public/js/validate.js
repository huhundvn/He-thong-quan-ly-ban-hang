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