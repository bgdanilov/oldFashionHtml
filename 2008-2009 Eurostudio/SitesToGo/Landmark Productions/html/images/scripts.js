function random_pic(){

var list_length = 6;
pic_num=parseInt(Math.random()*list_length);
pic_num=(isNaN(list_length))?0:pic_num + 1;
document.write(unescape('<img src="images/rightcol_img' + pic_num + '.jpg"  />'));

}