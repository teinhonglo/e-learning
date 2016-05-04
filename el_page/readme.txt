資料夾：

add_uploader：
為管理員介面的模組。
含有新增、刪除上傳者的功能。

add_video：
為上傳者介面的模組。
含有新增、刪除、修改影片及被授權者的功能。

viewer_list：
為觀看者頁面的模組。
被授權者有權利觀看影片，有密碼檢查、觀看影片的功能。

log_list：
為瀏覽歷程紀錄的模組。
看瀏覽歷程的功能。

images：
為放置icon、logo、主要圖片的地方。

css：
為放置控制全域的dedualt.css

playe_video：
為整個影片播放的方法。


video：
放置影片的地方。


tutorial：
放教學文件的地方，共有PDF、PPT兩個檔案。

----------------------------------------------------------

PHP檔案：

index.php：
首頁

check_e_learning_permission.php：
確認使用者身份，
管理員 = 3、
上傳者 = 2、
觀看者 = 1。

check_video_permission.php：
為確認使用者權限的function.
接受的參數有兩個，分別為$VideoID、$ln

合法使用者(有被授權，且在時間區段內)回傳2。
半合法使用者(有被授權，但不在時間區段內)回傳1。
非法使用者(沒有被授權，但不在時間區段內)回傳0。

onetime_password.php：
可以使用這個檔案來產生隨機不重複的編碼

extend_submit.php：
呈現申請影片權限的頁面

send_request_email.php：
寄出申請權限的email

SendAssignEmail.php：
內建兩個產生email內容的function，分別為，
1.授權影片觀看的通知信
2.申請影片觀看權的申請信

create_e_learning_table.php：
為建表的SQL command，如果要init，就執行一下即可。(Admin才可使用)


------------------------------------------------------------------

目前沒用到的檔案，
assign_member.php
dist以及其資料夾