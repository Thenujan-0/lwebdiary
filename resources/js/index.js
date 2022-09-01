
$(document).ready(function(){
    
    let main =$(".main")

    let selDiary= {
        name:function(){
            /* Returns name of the selected Diary */
            return $("p#diaryName").text()
        },
        date:function(){
            /*Returns the selected date of the diary  */
            return $(".diaryDataHeader p.selectedDate").text()
        }
    }


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



        let selectedDiary_=selDiary.name()
        let selectedDate=selDiary.date()
        // console.log("selectedDiary",selectedDiary_)
        let data = {date:selectedDate,selectedDiary:selectedDiary_}
        $.get("diaryEntry/show",data,function (response){
            // console.log(response,"resp")
            let currSelectedDiary= selDiary.name()
            let currselectedDate=selDiary.date()


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
        console.log("btnDate callback")
        let date=$(this).val()=="" ? $(this).text() : $(this).val()
        console.log(date)

        //Last selected date
        let lastSelDate=selDiary.date()
        console.log(lastSelDate)

        if(lastSelDate==date){
            return;
        }


        //Remove selected from date (technically there should only be one)
        $(".btnDate.selected").removeClass("selected")
        $(this).addClass("selected")

        $(".diaryDataHeader p.selectedDate").text(date)

        setDiaryData()
        disableEditMode()


        ///Handle empty diaryNames
        handleEmptyDiaryNames()
    }
    $(".btnDate").click(btnDateCallback)
    $("select#selectedDateInput").change(btnDateCallback)


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
        let selectedDiary_= $("p#diaryName").text()
        let textData= $("p.diaryData").text()
        

        //check if it is empty by checking 
        //If it has an inline write button,
        //If it does then we are ediing an empty entry
        if($(".btnWriteInline").length>0){

            //We have to do some processing to remove the inline write button from the text
            textData = textData.substr(0,textData.length-5)
            console.log(textData)
            let data={_token:token,
                "diaryName":selectedDiary_,
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

            handleEmptyDiaryNames()

        //If it is not > 0, we are editing an existing entry
        }else{
            console.log(textData)
            let data={
                diaryName:selDiary.name(),
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
        // unHideWriteInline()
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
        if(!$(this).hasClass("selected")){
            $(".btnDiary.selected").removeClass("selected")
            $(this).addClass("selected")
            $("p#diaryName").html($(this).text())
            setDiaryData()
            
        }
    });

    //Add btnDiary SmallScreen callback
    main.find("select.diaryNames").change(function(){
        console.log($(this).val(),"value now")
        $("p#diaryName").html($(this).val())
        setDiaryData()

    })

    function addBtnWriteInlineListener(){
        //Add btnWriteInline callback
        $(".btnWriteInline").click(function(){
            enableEditMode()
            handleEmptyDiaryNames()
        
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

        if (file.type!="application/json"){
            return;
        }

        const reader =new FileReader();
        reader.readAsText(file,"UTF-8");
        reader.onload = function(event){
            $.post("importDiary",{_token:token,fileData:event.target.result},function(response){
                console.log("response of import",response)
            })
        }
        
        
    })
    



function addSkeleton(){
    $("div.diaryDataSkeletons").css("display","block")
    $("p.diaryData").css("display","none")
}
function removeSkeleton(){
    $("div.diaryDataSkeletons").css("display","none")
    $("p.diaryData").css("display","inline")
}

//Handle empty diaryNames
function handleEmptyDiaryNames(){
    let data= {_token:token,date:selDiary.date()}
    $.post("getEmptyDiaryNames",data,function(response){
        // response.array.forEach(element => {
        //     $(".btnDiary")
        // });
        let emptyDiaries;
        try{
            emptyDiaries= JSON.parse(response)
        }catch(e){
            console.log(response)
            console.log(e)
        }
        let diaryNames= $("button.btnDiary")
        console.log(emptyDiaries)
        diaryNames.each((key,arg)=>{
            elem =$(arg)
            if(emptyDiaries.includes(elem.text())){
                elem.addClass("empty")
            }else{
                elem.removeClass("empty")
            }
        })

    })

}
handleEmptyDiaryNames()












})