<?php
  include 'header.php';
  include 'navbar.php';
?>

<!-- Main[Start] -->
<form method="post" action="insert.php">
  <div>
   <fieldset>
    <legend>書籍ブックマーク</legend>
     <label>書籍名：<input type="text" name="name" id="book_title"></label><br>
     <label>書籍URL：<input type="text" name="url" id="book_url"></label><br>
     <span id="book_img"></span><span id="img_text"></span><br>
     <label>書籍コメント：<textArea name="comment" rows="4" cols="40"></textArea></label><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>

<span id="search_box">
  <input type="text" id="keyword">
  <button id="search" class="btn btn-info">書籍検索</button>
</span>

<div id="content">
  <table>
    <tbody id="table">
    </tbody>
  </table>
</div>

<!-- Main[End] -->

<script>
  $('#search').on('click', function() {
    var keyword = $('#keyword').val();
    $.getJSON(
      "https://www.googleapis.com/books/v1/volumes?q="+keyword,
      // key = https://developers.goodle.com/books/docs/v1/using#query-param を参照
      function(data) {
        console.dir(data);

        var view = '';
        for (var i=0; i<data.items.length; i++) {
          var item = data.items[i];
          view += '<tr>';
          view += '<td>題名：<span class="title" id="' + i + '">' + item.volumeInfo.title + '</span></td>';
          view += '<td>出版社：' + item.volumeInfo.publisher + '</td>';
          view += '<td><img src="' + item.volumeInfo.imageLinks.smallThumbnail + '"></td>';
          view += '<td>情報：<a href="' + item.volumeInfo.previewLink + '" target="blank">リンク</a></td>';
          view += '</tr>';
        }
        $('#table').html(view);

        $('.title').on('click', function() {
          console.log(this.innerHTML);
          console.log(this.id);
          $('#book_title').val(this.innerHTML);
          $('#book_url').val(data.items[this.id].volumeInfo.previewLink);
          $('#book_img').html('<img src="' + data.items[this.id].volumeInfo.imageLinks.smallThumbnail + '">');
          $('#img_text').html('<input type="hidden" name="img" value="' + data.items[this.id].volumeInfo.imageLinks.smallThumbnail + '">');
        });

      }
    );
  });

</script>

</body>
</html>
