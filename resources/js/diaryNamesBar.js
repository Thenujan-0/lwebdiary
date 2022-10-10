
$(document).ready(function(){
    let bar= $("#diaryNamesBar")
    console.log(bar.width())
    console.log(bar.prop("scrollWidth"))
    console.log("why is this not working?")
    console.log("So this is working?")
    console.log("totally")

    const diaryNamesBar={
        scrollButtons:$("#diaryNamesBar i"),
        hiddenElements:[],
        resizeTimeout:null,

        getElems:function(){
            return $("#diaryNamesBar button.btnDiary")
        },
        

        overflowing:function(){
            return bar.prop("scrollWidth")- bar.width() >5 
        },

        overflowWidth:function(){
            return bar.prop("scrollWidth")- bar.width()
        },

        remainingWidth:function(){
            return $("#diaryContent").width()-$("#diaryNamesBar").width()
        },

        handleScrollButtons:function (){

            if (diaryNamesBar.hiddenElements.length>0){
                diaryNamesBar.scrollButtons.each(function(){$(this).css("display","inline")})
            }else{
                diaryNamesBar.scrollButtons.each(function(){$(this).css("display","none")})

            }

        },

        handleElements:function(){
            console.log("handleElements is running")

            if (diaryNamesBar.overflowing()){
                //Remove items one by one as they overflow
                while (diaryNamesBar.overflowing() && diaryNamesBar.getElems().length>1){
                    console.log("removing item")
                    console.log(diaryNamesBar.getElems().length)
                    lastElem=diaryNamesBar.getElems().last()

                    diaryNamesBar.hiddenElements.push({
                        elem:lastElem,
                        width:lastElem.width()
                            +parseInt(lastElem.css("padding-left"))
                            +parseInt(lastElem.css("padding-right"))
                    })

                    lastElem.remove()
                }
                if(diaryNamesBar.overflowing() && diaryNamesBar.getElems().length==1){
                    $("div.diaryNames").css("display","none")
                    $("select.diaryNames").css("display","block")
                }

            }else{
                let hidden=diaryNamesBar.hiddenElements;
                if (hidden.length==0){
                    return
                }
                console.log(hidden,"hidden elements list")
                elemWidth=hidden[hidden.length-1].width
                console.log(elemWidth,"elemWidth")
                console.log("remainingWidth",diaryNamesBar.remainingWidth())

                while (diaryNamesBar.remainingWidth()>elemWidth && hidden.length>0){
                    console.log("appending item")
                    // $("div.diaryNames").append(hidden[hidden.length-1].elem)
                    diaryNamesBar.appendItem(hidden[hidden.length-1].elem)
                    hidden.splice(hidden.length-1)

                }
            }
            


        },
        appendItem:function(elem){
            console.log($("div.diaryNames i.btnNext"))
            console.log(elem)
            elem.insertBefore($("div.diaryNames i.btnNext"))
        },

        onresize:function(){
            if (!diaryNamesBar.resizeTimeout){

                //This timeout is used to make sure that these functions are not called too often
                diaryNamesBar.resizeTimeout=setTimeout(function(){diaryNamesBar.resizeTimeout=null},100)

                diaryNamesBar.handleElements()
                diaryNamesBar.handleScrollButtons()
            }else{
                
            }
        }

    }

    $(window).resize(diaryNamesBar.onresize)
})