<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="bg-secondary">
    
    <div class="container mt-5 p-5">
        <div class="card">
            <h3 class="card-header">ARTICLE</h3>
            <div class="card-body">
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem consectetur iusto asperiores incidunt nam nostrum animi fuga optio labore, magni fugit, blanditiis laborum at corrupti repellat unde. Suscipit, ut nesciunt!</p>
            </div>
            <div class="card-footer bg-white">
              <div class="alert-message">
              
              </div>
           <form >
            <div class="form-group">
                <input type="text" class="mt-2 mb-2 form-control name" placeholder="Name" >
             </div>
            <div class="form-group">  
                    <textarea class="form-control  comment_body" placeholder="write comment"></textarea>
                 <button class="float-right btn btn-success m-2 submit">Submit</button>
            </div>
           </form>
                <div class="d-flex">
                    <button class="btn">Like</button>
                    <button class="btn comment">Comment</button>
                </div>
             <div class="main-comment">
                
             </div>
            </div>
        </div>
        
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="./jquery-3.3.1.min.js"></script>
    <script >
        $(document).ready(function(){
            $(".comment").click((e)=>{
                $(".comment_body").css({
                    display: "block"
                })
            })

            $(document).on("click",".replay",function(){
                $(".comment_body").css({
                    display: "block"
                }).focus();

                var value=$(this).attr("sendername");
                $(".comment_body").val(`Replay to  ${value}  `)

            })

            $(".submit").on("click",function(e){
                e.preventDefault();
                var data={
                    name : $(".name").val(),
                    comment : $(".comment_body").val(),
                    "insert" : "insert"
                };

                $.ajax({
                    method: "POST",
                    dataType: "JSON",
                    data : data,
                    url : "comment.php",
                    success : (response)=>{
                        if(response.error){
                            $('.alert-message').html(`
                            <div class="alert alert-danger">
                                <h6>${response.message}</h6>
                            </div>
                            
                            `)
                        }else{
                            $('.alert-message').html(`
                            <div class="alert alert-success">
                                <h6>${response.message}</h6>
                            </div>
                            
                            `)

                            loadComments();
                            $(".comment_body").val("");
                            $(".comment_body").css({
                                display : "none"
                            })
                            $(".name").val("");
                       
                        }
                    },
                    error : (response)=>{
                        $('.alert-message').html(`
                            <div class="alert alert-danger">
                                <h6><${response['responseText']}/h6>
                            </div>
                            
                            `)
                    }
                })
            })

            loadComments();
            function loadComments(){
                var data ={"fetch": "fetch"}
                $.ajax({
                    method: "POST",
                    dataType: "JSON",
                    data : data,
                    url : "comment.php",
                    success : (response)=>{
                        if(response.error){
                            $('.alert-message').html(`
                            <div class="alert alert-danger">
                                <h6>${response.message}</h6>
                            </div>
                            
                            `)
                        }else{
                          
                          
                            $(".main-comment").html("");
                           response.response.map((e)=>{
                            console.log(e)
                            $(".main-comment").append(
                                `
                                <div class="comment-card mb-2">
               
            
                                <div class="comment-card-body">
                    <div class="sender-name">
                        <h6>By <b  class="sender">${e[1]}</b> <span class="text-muted">On ${e[3]}</span></h6>
                    </div>
                    <div class="sender-comment">
                        <div class="body">
                            <p>${e[2]}</p>
                            <button  sendername="${e[1]}" class="btn float-right replay">
                                replay
                             </button>
                        </div>
                       
                    </div>
                </div>
            </div>
                                
                                `
                            )
                           })
                          
                       
                        }
                    },
                    error : (response)=>{
                        $('.alert-message').html(`
                            <div class="alert alert-danger">
                                <h6><${response['responseText']}/h6>
                            </div>
                            
                            `)
                    }
                })
            }
        })


    </script>
</body>
</html>