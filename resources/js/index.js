import {cacher } from "./includes/cacher.js"
import {menuPopup} from "./menuPopup.js"


$(document).ready(function(){
    
    let main =$(".main")

    let selDiary= {
        /**Returns selected DiaryName */
        name(){
            return $("p#diaryName").text()
        },
        
        /**Returns selected Date */
        date(){
            return $(".diaryDataHeader p.selectedDate").text()
        },
        
        /**Returns selected diaryName ,selected Date */
        get(){
            return [this.name(),this.date()]
        }
    };

    /**init cacher with diaryNames */
    (function(){
        let diaryNames = $(".btnDiary").toArray()
        let diaryNamesDict={};

        diaryNames.forEach(function(elem){
            let text = elem.textContent
            let id = elem.getAttribute("data-id")
            //console.log(id,text)
            diaryNamesDict[id]=text
        })
        // console.log(diaryNamesDict)
        cacher.init(diaryNamesDict)
    })()



    function hideWriteInline(){
        $(".btnWriteInline").css("display","none")
    }

    function unHideWriteInline(){
        $(".btnWriteInline").css("display","inline")
    }




    
    
    
    
    let diaryData= {
        set(){

        },
        /**Handles the retrived data */
        handleData(){

        }
    }



    /** if the selected date exists in cache, sets the diary and returns true.
        returns false if date doesn't exist in cache
    */
    function setDiaryDataFromCache(selDiary,selDate){
        if(cacher.dateExists(selDate)){
            //console.log(cacher.diaries[selectedDate])
            let response=cacher.diaries[selDate][selDiary]
            //console.log("response",response)
            if(response && response!=""){
                $(".diaryData").html(response)
            }else{
                $(".diaryData").html("Nothing written here :( <button class='btn btnWriteInline'>Write</button>")
                addBtnWriteInlineListener()
            }
            removeSkeleton()
            handleEmptyDiaryNames()

        }else{
            cacher.cacheNearByDates(selDate).done(function(){
                setDiaryDataFromCache(selDiary,selDate)
            })
        }

    }


    /**
     * Sets the currect diary data for the current date
     * @param  {} {refresh}={}
     */
    function setDiaryData({refresh=null}={}){
        /* refresh argument is date that has to be refreshed from cache */
        addSkeleton()

        console.log("refresh is",refresh)

        let selectedDiary=selDiary.name()
        let selectedDate=selDiary.date()
        // console.log("selectedDiary",selectedDiary_)
        if (refresh){
            console.log("refreshing")
            cacher.cacheDates([selectedDate]).done(function(){
                setDiaryDataFromCache(selectedDiary,selectedDate)
            })
            return;
        }
        setDiaryDataFromCache(selectedDiary,selectedDate)
    }

    //sets the diary data for last date 
    setDiaryData()


    /**
     * Download a specified file
     * @param  {} filename
     * @param  {} text
     */
    function download(filename, text) {
        var element = document.createElement('a');
        element.setAttribute('href', 'data:	application/json;charset=utf-8,' + encodeURIComponent(text));
        element.setAttribute('download', filename);
        
        element.style.display = 'none';
        document.body.appendChild(element);
        
        element.click();
        
        document.body.removeChild(element);
    }

    /**
     * BtnDate callback
     */
    function btnDateCallback(){
        //console.log("btnDate callback")
        let date=$(this).val()=="" ? $(this).text() : $(this).val()
        //console.log(date)

        //Last selected date
        let lastSelDate=selDiary.date()
        //console.log(lastSelDate)

        if(lastSelDate==date){
            return;
        }


        //Remove selected from date (technically there should only be one)
        $(".btnDate.selected").removeClass("selected")
        $(this).addClass("selected")

        $(".diaryDataHeader p.selectedDate").text(date)

        setDiaryData()
        editMode.disable()


        ///Handle empty diaryNames
        //handleEmptyDiaryNames()
    }
    $(".btnDate").click(btnDateCallback)
    $("select#selectedDateInput").change(btnDateCallback)

    let editMode={
        isEnabled(){
            return $("p.diaryData").attr("contentEditable")==="true"
        },
        enable(){
            $("p.diaryData").attr("contentEditable","true")
            $("p.diaryData").focus()
            $(".btnEdit").find(".fa-pen").addClass("fa-check").removeClass("fa-pen")
            hideWriteInline()
        },

        disable(){
            //console.log("disable edit mode was called")
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
                //console.log(textData)
                let selectedDate = $(".btnDate.selected").html()
                let data={_token:token,
                    "diaryName":selectedDiary_,
                    data:textData,
                    date:selectedDate,
                    allowDuplicateDates:true

                }
                //console.log(selectedDiary_,textData,data)
                
                //todo handle error response
                $.post("writeDiary",data,function(response){
                    //console.log(response)
                    setDiaryData({refresh:true})
                })

                handleEmptyDiaryNames()

            //If it is not > 0, we are editing an existing entry
            }else{
                //console.log(textData)
                let data={
                    diaryName:selDiary.name(),
                    data:textData,
                    _token:token,
                    date:$(".btnDate.selected").html()

                }
                $.post("editDiaryData",data,function(response){
                    //console.log(response)
                    setDiaryData({refresh:true})
                })
            }
            $("p.diaryData").attr("contentEditable","false")
            // $(".btnEdit").html("Edit")
            $(".btnEdit").find(".fa-check").addClass("fa-pen").removeClass("fa-check")
            // unHideWriteInline()
        },
        listenKeyboard(){

            /**Keyboard event of ctrl click to confirm edit */
            $("p.diaryData").keyup(function(e){
                if(e.ctrlKey && e.key.toLowerCase()==="enter" && editMode.isEnabled()){
                    editMode.disable()
                }
            })
        }

    }

    //Add btnEdit callback
    $(".btnEdit").click(function(){
        
        //console.log()
        if($(this).find(".fa-pen").length>0){
            editMode.enable()
        }else{
            editMode.disable()
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
                window.location.reload()
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
        //console.log($(this).val(),"value now")
        $("p#diaryName").html($(this).val())
        setDiaryData()

    })

    function addBtnWriteInlineListener(){
        //Add btnWriteInline callback
        $(".btnWriteInline").click(function(){
            editMode.enable()
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
            //console.log(response)
            //console.log(typeof response)
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

        if (file.type!="application/json"){
            return;
        }

        const reader =new FileReader();
        reader.readAsText(file,"UTF-8");
        reader.onload = function(event){
            $.post("importDiary",{_token:token,fileData:event.target.result},function(response){
                //console.log("response of import",response)
            })
        }
        
        
    })

    editMode.listenKeyboard()
    

    


    /**Add skeleton loader */
    function addSkeleton(){
        $("div.diaryDataSkeletons").css("display","block")
        $("p.diaryData").css("display","none")
    }

    /** Remove skeleton loader */
    function removeSkeleton(){
        /* Removes the skeleton loader */
        $("div.diaryDataSkeletons").css("display","none")
        $("p.diaryData").css("display","inline")
    }

    //Handle empty diaryNames
    function handleEmptyDiaryNames(){
        // let data= {_token:token,date:selDiary.date()}
        let date = selDiary.date()
        if (cacher.dateExists(date)){
            // console.log("--------------------")
            let emptyDiaries = cacher.emptyDiaries(date)
            emptyDiaryProcessor(emptyDiaries)
            console.log("yeah")
            return
        }else{
            console.log("cache doesnt have it")
        }

        function emptyDiaryProcessor(emptyDiaries){
            let diaryNames= $("button.btnDiary")
            // console.log(emptyDiaries)
            diaryNames.each((key,arg)=>{
                let elem =$(arg)
                if(emptyDiaries.includes(elem.text())){
                    elem.addClass("empty")
                }else{
                    elem.removeClass("empty")
                }
            })
        }


        
    }
    let userBtn =$(".btn.userBtn")

    userBtn.click(function(){
        let rect = userBtn[0].getBoundingClientRect()
        console.log(rect)
        menuPopup.show(rect.x+rect.width,rect.y+rect.height)
    })


})