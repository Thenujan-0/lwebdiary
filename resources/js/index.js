$(document).ready(function(){
    
    let main =$(".main")


    //Add btnWriteEntry callback
    $("#btnWriteEntry").click()

    function hideWriteInline(){
        $(".btnWriteInline").css("display","none")
    }

    function unHideWriteInline(){
        $(".btnWriteInline").css("display","inline")
    }

    //The following variable is used to know if a request to setDiary data is already pending
    window.pendingsetDiaryDataReq=false;
    function setDiaryData(){
        addSkeleton()
        // console.log("added skeleton")
        //If already a request is pending don't send another one
        // if (window.pendingsetDiaryDataReq){
        //     console.log("pending diary Data request")
        //     return;
        // }



        let selectedDiary_= $(".btnDiary.selected").html()
        let selectedDate=$(".btnDate.selected").html()
        // console.log("selectedDiary",selectedDiary_)
        let data = {date:selectedDate,selectedDiary:selectedDiary_}
        $.get("diaryEntry/show",data,function (response){
            // console.log(response,"resp")
            let currSelectedDiary= $(".btnDiary.selected").html()
            let currselectedDate=$(".btnDate.selected").html()


            //If the selected diary is not the same as the one this request was sent for, don't show the data
            if (data["selectedDiary"]!=currSelectedDiary || data["date"]!=currselectedDate){
                console.log(data["selectedDiary"],currSelectedDiary,data["date"],currselectedDate)
                return;
            }
            console.log("No")
            console.log(data["selectedDiary"],currSelectedDiary,data["date"],currselectedDate)

            if(response!=""){
                $(".diaryData").html(response)
            }else{
                $(".diaryData").html("Nothing written here :( <button class='btn btnWriteInline'>Write</button>")
                addBtnWriteInlineListener()
            }
            removeSkeleton()
        })
        // console.log("removed skeleton")
    }

    //sets the diary data for last date 
    setDiaryData()



    function download(filename, text) {
        var element = document.createElement('a');
        element.setAttribute('href', 'data:	application/json;charset=utf-8,' + encodeURIComponent(text));
        element.setAttribute('download', filename);
        
        element.style.display = 'none';
        document.body.appendChild(element);
        
        element.click();
        
        document.body.removeChild(element);
    }

    //Add btnDate callback
    function btnDateCallback(){
        let date=$(this).html()

        //Last selected date
        let lastSelDate=$('.btnDate.selected').html()

        if(lastSelDate==date){
            return;
        }


        //Remove selected from date (technically there should only be one)
        $(".btnDate.selected").removeClass("selected")
        $(this).addClass("selected")
        setDiaryData()
        disableEditMode()
    }
    $(".btnDate").click(btnDateCallback)


    function enableEditMode(){
        $("p.diaryData").attr("contentEditable","true")
        $("p.diaryData").focus()
        $(".btnEdit").html("Save")
        hideWriteInline()
    }

    function disableEditMode(){
        if($("p.diaryData").attr("contentEditable")!="true"){
            return 
        }
        let selectedDiary_= $(".btnDiary.selected").html()
        let textData= $("p.diaryData").text()
        

        //check if it is empty by checking 
        //If it has an inline write button,
        //If it does then we are ediing an empty entry
        if($(".btnWriteInline").length>0){

            //We have to do some processing to remove the inline write button from the text
            textData = textData.substr(0,textData.length-5)
            console.log(textData)
            let data={_token:token,
                selectedDiaries:selectedDiary_,
                data:textData,
                date:$(".btnDate.selected").html(),
                allowDuplicateDates:true

            }
            console.log(selectedDiary_,textData,data)
            
            //todo
            $.post("writeDiary",data,function(response){
                console.log(response)
                setDiaryData()
            })

        //If it is not > 0, we are editing an existing entry
        }else{
            console.log(textData)
            let data={
                selectedDiary:selectedDiary_,
                data:textData,
                _token:token,
                date:$(".btnDate.selected").html()

            }
            console.log(selectedDiary_,textData,data)
            $.post("editDiaryData",data,function(response){
                console.log(response)
                setDiaryData()
            })
        }
        $("p.diaryData").attr("contentEditable","false")
        $(".btnEdit").html("Edit")
        unHideWriteInline()
    }

    //Add btnEdit callback
    $(".btnEdit").click(function(){
        if($(this).html()=="Edit"){
            enableEditMode()
        }else{
            disableEditMode()
        }
    })

    // Add delete callback
    main.find(".btnDel").click(function(){
        let date_=$(".btnDate.selected").html()
        $.ajax({
            url:"diaryEntry/destroy",
            
            type:"DELETE",
            data:{date:date_,
                _token:token,},
            complete:function(response){
                console.log(response)
                window.location.reload()
                console.log("reloaded")
                }
        })
    })


    


    //Add btnDiary callback
    main.find(".btnDiary").click(function(){
        // if(!$(this).hasClass("selected")){
        //     $(".btnDiary.selected").removeClass("selected")
        //     $(this).addClass("selected")
        //     setDiaryData()
        // }
    });

    function addBtnWriteInlineListener(){
        //Add btnWriteInline callback
        $(".btnWriteInline").click(function(){
            enableEditMode()
        
        })
    }


    //Add btnWrite callback
    $(".btnWrite").click(function(){
        let form=$("#formWriteDiary")
        let darkOverlay=$("#darkOverlay")
        if(form.css("display")=="none"){
            form.css("display","flex")
            darkOverlay.css("display","block")
        }else{
            form.css("display","none")
            darkOverlay.css("display","none")

        }
    })


    //Add btnExport callback
    $("#btnExport").click(function(){
        let data={_token:token}

        $.post("exportDiary",data,function(response){
            console.log(response)
            console.log(typeof response)
            download("teraDiaryExport.json",response) //todo remove this
            // window.open(response)
        })
    })

    //Add btnImport callback
    $("#btnImport").click(function(){
        $("#importFileInput").click()
    })


    //Add importFileInput callback
    $("#importFileInput").change(function(event){
        let files=event.target.files
        let file=files[0]
        console.log(file.name)
        console.log(file.type)
        console.log($(this).val())
    })
    



function addSkeleton(){
    $("div.diaryDataSkeletons").css("display","block")
    $("p.diaryData").css("display","none")
}
function removeSkeleton(){
    $("div.diaryDataSkeletons").css("display","none")
    $("p.diaryData").css("display","inline")
}




})