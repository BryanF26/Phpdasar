// ambil element
const keyword = document.getElementById('keyword') 
const tombolCari = document.getElementById('tombol-cari')
const container = document.getElementById('container')

keyword.addEventListener('keyup', ()=>{
    // buat object ajax
    let xhr = new XMLHttpRequest()

    // cek kesiapan ajax
    xhr.onreadystatechange = ()=>{
        // kalo readystate 4 udah okay dan status 200 udah ok 
        if(xhr.readyState == 4 && xhr.status == 200){
            container.innerHTML = xhr.responseText
        }
    }

    // eksekusi ajax-> .open(request method, sumber, synchronus / asynchronus)
    xhr.open('GET', 'ajax/produk.php?keyword='+keyword.value+'&word=1', true)
    xhr.send()
})