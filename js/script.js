var keyword = document.getElementById("keyword");
var container = document.getElementById("container");
var pagination = document.getElementById("pagination");





keyword.addEventListener('keyup', function() {
    // menyembunyikan pagination
    if (keyword.value.trim() !== "") {
        pagination.style.display = "none";
    } else {
        pagination.style.display = "block";
    }

    // buat object ajax
    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            container.innerHTML = ajax.responseText;
        }
    }

    // eksekusi ajax
    ajax.open('GET', 'ajax/barang.php?keyword=' + keyword.value, true);
    ajax.send();
})