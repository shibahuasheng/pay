# pay
微信问答平台<br>
项目实现的功能：<br>
1.任何用户通过微信可以登录问答平台，并且通过微信支付向答主提出自己的问题<br>
2.平台答主可以可以看到用户提供的问题，并且在线解答<br>
3.任何用户都可以看到询问别人问题列表，以及偷听列表<br>
4.所有答主已经回答问题，倒序输出在首页里，用户可付费偷听，并可查看偷听次数<br>
项目数据表清单<br>
用户表<br>
问题表<br>
偷听表<br>
api接口清单<br>
asklist清单 获取用户提出的所有问题<br>
askmelist 答主获取所有提问者提出的问题<br>
listenlist 三表联查 获取偷听问题<br>
askquestion 用户提出问题后将数据写入问题表<br>
check_listen 用户偷听次数+1 并且写入偷听表<br>
checkask 获取一个语音所有用户信息<br>
checkpay 判断用户偷听是否支付 如果支付可畅听 如果没有支付需支付<br>
getanswer 获得某个回答者的信息<br>
getMedia 下载语音接口<br>
getteacherlist 获得所有答主清单<br>
login 用户登录接口 获取用户所有信息 并导入数据库 将用户基本信息保存到session<br>
update_ask 改变问题状态 如果问题已经被回答 数据库更新<br>
uploadamr.php 上传语音 获得media id在客户端播放<br>
前端界面清单<br>
index 主界面获取已回答的问题列表 有分页功能<br>
index2 答主清单 可以向答主提出问题<br>
index3 登录着界面 可获得我问 我答 我听<br>
answer 答主回答问题 并且录音保存在本地页面 信息插入数据库<br>
ask 用户支付 并且提供问题<br>
listen 用户完成偷听支付 上传本地语音并且完成偷听<br>
