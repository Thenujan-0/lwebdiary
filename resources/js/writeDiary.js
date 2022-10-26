
$(document).ready(function() {
    let form =$("#formWriteDiary")

    let errorHandler={

        date(errorMsg=""){
            console.log(errorMsg)
            if(errorMsg!=""){
                form.find("div.date p.errorMsg").html(errorMsg)
                form.find("div.date > .error").css("visibility","visible")
            }else{
                form.find("div.date > .error").css("visibility","hidden")
            }
        },


        diaries(errorMsg=""){
            if(errorMsg!=""){
                form.find("div.selectedDiaries  p.errorMsg").html(errorMsg)
                form.find("div.selectedDiaries > div.error").css("visibility","visible")
            }else{
                form.find("div.selectedDiaries > div.error").css("visibility","hidden")
            }
        },

        diaryData(errorMsg=""){
            if(errorMsg!=""){
                form.find("div.diaryText p.errorMsg").html(errorMsg)
                form.find("div.diaryText > div.error").css("visibility","visible")
            }else{
                form.find("div.diaryText > div.error").css("visibility","hidden")
            }
        },
        /**Removes all errors */
        empty(){
            this.diaries()
            this.diaryData()
            this.date()
        }
    }

    let selDiary= {
        select:form.find("select[name='diaryName']"),
    
        get:function(){
            return selDiary.select.val()
        },
    
        set: function(value){
            selDiary.select.val(value)
        }
    }



    function checkDateExists(){
        let date_ =form.find("#date").val()

        var data = { action: 'dateExists',date :date_,_token:token};
        // console.log("checking dateexists")

        $.post("dateExists", data, function(response) {
            // console.log("")
            if(response === "true") {
                errorHandler.date("Date already exists")
                // let valid = false
            }else{
                errorHandler.date()
            }
        });
    } 

    //btnBackWriteDiary callback
    form.find("#btnBackWriteDiary").click(function(){
        form.css("display","none")
        $("#darkOverlay").css("display","none")
        //Remove all the error messages
        errorHandler.empty()

    })

    //Check if valid date when the user types diary
    let typeTimeout=null
    form.find("textarea#diaryText").on("input",

        function(){
            if(typeTimeout==null){
                // console.log("changed")
                typeTimeout=setTimeout(function(){typeTimeout=null},1000)
                checkDateExists()
            }
        }
    )

    //Check if valid date when date is changed

    form.find("input#date").change(checkDateExists());



    form.ajaxForm({
        beforeSubmit:  function() {
            
            var valid=true
            
            //Check if at leaset one diary is selected
            // if(form.find("#selectedDiaries").val()===""){
            //     errorHandler.diaries("Please select at least one diary")
            //     valid = false

            // }else{
                // errorHandler.diaries()
            // }

            //Check if something is written in diary
            if(form.find("#diaryText").val()===""){
                errorHandler.diaryData("Please write something in the diary")
                valid=false
            }else{
                errorHandler.diaryData()
            }

            return valid
            
        },

        complete: function(xhr) {
            // console.log(xhr.responseText)
            if(xhr.responseText==="true"){
                // console.log("clicked back button")
                form.find("#btnBackWriteDiary").click()
                window.location.reload()
            }else{
                console.log("Warning : unexpected response from server when writing to diary")
                console.log(typeof xhr.responseText)
                try{
                    let obj = JSON.parse(xhr.responseText)

                    let  { errors:{date:messages}} = obj
                    console.log(messages)

                    let finalMessage = messages.reduce(function(acc,curr){
                        return acc+curr+"<br>"  
                    },"")
                    errorHandler.date(finalMessage)
                    console.log(finalMessage)
                }catch(e){
                    console.log("caught error",e)
                }
                    console.log(xhr.status)
                
            }
        }
    })

    //Automatically set the date
    let today = new Date();
    form.find("#date").val(today.toISOString().substring(0, 10));


    //Increase the size of textarea depending on the text inside
    form.find("textarea").keypress(() => {
        let tArea= form.find("textArea")[0]
        tArea.style.height = "5px";
        tArea.style.height = tArea.scrollHeight+10 + "px";

    })

    /**Ctrl+Enter from textarea to submit */
    form.find("textarea").keyup(function(e){
        if(e.ctrlKey && e.key.toLowerCase()=="enter"){
            form.find("input[type='submit']").click()
        }
    })


});
