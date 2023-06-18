function darkOFF(){
    $('#bodyCol').removeClass('bg-warning bg-secondary').addClass('bg-warning');
    $('body').attr('data-color', "bg-gradient-x-orange-yellow");
    $('.main-menu').removeClass('menu-dark menu-light').addClass('menu-light');
    $('.card').removeClass('bg-white bg-dark').addClass('bg-white');
    $('.card-header').removeClass('bg-white bg-dark').addClass('bg-white');
    $('table').removeClass('table-default table-dark').addClass('table-default');
    $('.card-title').removeClass('bg-white bg-dark').addClass('bg-white');
    $('.card').removeClass('color: white color: grey').addClass('color: grey');
    $('.card-text').removeClass('text-white text-black').addClass('text-black');
    $('#projects').removeClass('text-white text-black').addClass('text-black');
    $('H6').removeClass('color: white color: grey').addClass('color: grey');
    $('label').removeClass('color: white color: grey').addClass('color: grey');
    $('.footer').removeClass('bg-white bg-dark').addClass('bg-white');
}

function darkON(){
    $('#bodyCol').removeClass('bg-warning bg-secondary').addClass('bg-secondary');
    $('body').attr('data-color', "bg-gradient-x-blue-cyan");
    $('.main-menu').removeClass('menu-dark menu-light').addClass('menu-dark');
    $('.card').removeClass('bg-white bg-dark').addClass('bg-dark');
    $('.card-header').removeClass('bg-white bg-dark').addClass('bg-dark');
    $('table').removeClass('table-default table-dark').addClass('table-dark');
    $('.card-title').removeClass('bg-white bg-dark').addClass('bg-dark');
    $('.card').removeClass('color: white color: grey').addClass('color: white');
    $('.card-text').removeClass('text-white text-black').addClass('text-white');
    $('#projects').removeClass('text-white text-black').addClass('text-white');
    $('H6').removeClass('color: white color: grey').addClass('color: white');
    $('label').removeClass('color: white color: grey').addClass('color: white');
    $('.footer').removeClass('bg-white bg-dark').addClass('bg-dark');
}

