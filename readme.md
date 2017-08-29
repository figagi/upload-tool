~~~~
知识要点
1.表单正确上传文件姿势 enctype="multipart/form-data" method="post",缺一不可
2.如果使用Phpstorm开发，切记要手动配置Server 如果使用Phpstorm自带服务器则获取不到post提交的任何数据，而get方式提交的数据可以正常获取到
3.查看php.ini文件中上传文件是否启用
4.检测文件大小，扩展名，保存路径是否合法，参考demo代码
5.文件上传失败时，错误提示，了解文件上传基本的error
~~~~

