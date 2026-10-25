function close_shop() {
    document.getElementById('shop_levitation').style.display = 'none';
};

document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('cont');
    const windElement = document.getElementById('Send_msg');

    function checkTextarea() {
        if (textarea.value.trim() !== '') {
            windElement.style.display = 'block';
        } else {
            windElement.style.display = 'none';
        }
    }

    checkTextarea();

    textarea.addEventListener('input', checkTextarea);
});

document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('cont');
    const windElement = document.getElementById('Send_img');

    function checkTextarea() {
        if (textarea.value.trim() == '') {
            windElement.style.display = 'block';
        } else {
            windElement.style.display = 'none';
        }
    }

    checkTextarea();

    textarea.addEventListener('input', checkTextarea);
});

function hide_button() {
    Send_msg.style.display = 'none';
    Send_img.style.display = 'block';
}

function appraise() {
    document.getElementById('appraise').style.display = 'flex';
    document.getElementById('close_appraise').style.display = 'flex';
}

function close_appraise() {
    document.getElementById('appraise').style.display = 'none';
    document.getElementById('close_appraise').style.display = 'none';
    document.getElementById('cgtipstext').innerHTML = "评价成功";
    document.getElementById('cgtips').style.display = 'flex';
    setTimeout(function() {
        document.getElementById('cgtips').style.display = 'none';
    }, 1500);
}

function emoji1() {
    document.getElementById('emoji1').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-1-active.png';
    document.getElementById('emoji2').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-2.png';
    document.getElementById('emoji3').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-3.png';
    document.getElementById('emoji4').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-4.png';
    document.getElementById('emoji5').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-5.png';
}

function emoji2() {
    document.getElementById('emoji1').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-1.png';
    document.getElementById('emoji2').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-2-active.png';
    document.getElementById('emoji3').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-3.png';
    document.getElementById('emoji4').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-4.png';
    document.getElementById('emoji5').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-5.png';
}

function emoji3() {
    document.getElementById('emoji1').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-1.png';
    document.getElementById('emoji2').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-2.png';
    document.getElementById('emoji3').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-3-active.png';
    document.getElementById('emoji4').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-4.png';
    document.getElementById('emoji5').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-5.png';
}

function emoji4() {
    document.getElementById('emoji1').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-1.png';
    document.getElementById('emoji2').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-2.png';
    document.getElementById('emoji3').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-3.png';
    document.getElementById('emoji4').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-4-active.png';
    document.getElementById('emoji5').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-5.png';
}

function emoji5() {
    document.getElementById('emoji1').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-1.png';
    document.getElementById('emoji2').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-2.png';
    document.getElementById('emoji3').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-3.png';
    document.getElementById('emoji4').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-4.png';
    document.getElementById('emoji5').src = 'https://oss.pzds.com/mobileV3/icon-satisfaction-5-active.png';
}


const toggleButton = document.getElementById('icon_button1');
const targetElement = document.getElementById('icon1');

toggleButton.addEventListener('click', function () {
    if (targetElement.className === 'noactivation') {
        targetElement.className = 'yesactivation';
        document.getElementById('mini_crad2').style.display = 'none';
        document.getElementById('mini_crad').style.display = 'flex';
        document.getElementById('icon2').className = 'noactivation';
    } else {
        targetElement.className = 'noactivation';
        document.getElementById('mini_crad').style.display = 'none';
    }
});

const toggleButton1 = document.getElementById('icon_button2');
const targetElement1 = document.getElementById('icon2');

toggleButton1.addEventListener('click', function () {
    if (targetElement1.className === 'noactivation') {
        document.getElementById('mini_crad').style.display = 'none';
        document.getElementById('mini_crad2').style.display = 'flex';
        document.getElementById('shareclose01').style.display = 'flex';
        targetElement1.className = 'yesactivation';
        document.getElementById('icon1').className = 'noactivation';
    } else {
        document.getElementById('mini_crad2').style.display = 'none';
        targetElement1.className = 'noactivation';
    }
});

function close_windows() {
    document.getElementById('windwo_101').style.display = 'none';
    document.getElementById('share2').style.display = 'none';
};

function open_windwos() {
    document.getElementById('windwo_101').style.display = 'flex';
    document.getElementById('share2').style.display = 'flex';
};

function shouqian() {
    document.getElementById('xuanxiang').innerHTML = "售前问题"
    document.getElementById('windwo_101').style.display = 'none';
    document.getElementById('share2').style.display = 'none';
}

function shouhou() {
    document.getElementById('xuanxiang').innerHTML = "售后问题"
    document.getElementById('windwo_101').style.display = 'none';
    document.getElementById('share2').style.display = 'none';
}

function jiaoti09() {
    document.getElementById('cgtipstext').innerHTML = "问题反馈成功";
    document.getElementById('cgtips').style.display = 'flex';
    setTimeout(function() {
        document.getElementById('cgtips').style.display = 'none';
        window.location.href = "/panzhi.php";
    }, 1500);
}

function shareclose01() {
    document.getElementById('mini_crad2').style.display = 'none'
    document.getElementById('shareclose01').style.display = 'none'
};

function gzbtn_1() {
    let gzbtn_1 = document.getElementById('gzbtn_1');
    gzbtn_1.style.backgroundColor = "#13bf78";
    gzbtn_1.innerHTML = "已关注"
};

function gzbtn_2() {
    let gzbtn_2 = document.getElementById('gzbtn_2');
    gzbtn_2.style.backgroundColor = "#13bf78";
    gzbtn_2.innerHTML = "已关注"
};

function gzbtn_3() {
    let gzbtn_3 = document.getElementById('gzbtn_3');
    gzbtn_3.style.backgroundColor = "#13bf78";
    gzbtn_3.innerHTML = "已关注"
};

function gzbtn_4() {
    let gzbtn_4 = document.getElementById('gzbtn_4');
    gzbtn_4.style.backgroundColor = "#13bf78";
    gzbtn_4.innerHTML = "已关注"
};