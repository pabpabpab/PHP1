<form enctype='multipart/form-data' method='post' action='/?p=personal_area&a=addProduct'>
    <input type='text' placeholder='наименование товара' name='name' class='field'><br><br>
    <input type='text' placeholder='цена товара' name='price' class='field'><br><br>
    <textarea placeholder='описание товара' name='description' class='field'></textarea><br><br>
    <div class='hint'>можно выбрать несколько фото</div>
    <input type='file' name='userfile[]' multiple class='field'><br><br>
    <input type='submit' name='addproduct' class='field'>
</form>
