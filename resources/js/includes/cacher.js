let cacher ={
    fake:true,
    diaryNames:{}, //Contains diaryNameIds and their diaryNames
    diaries: {},//{date:{diary_name:data,empty_diaries:[]}}
    init:function(diaryNames,diaries){
        cacher.diaryNames=diaryNames
        if(diaries!= undefined){
            cacher.diaries = diaries
        }
    },

    set :function(date, diaryNameId,data){
        /* Here , data is a dictionary which contains diaryNameIds and diary data */
        // console.log(cacher.diaries,"this",cacher.diaryNames)
        let diaryName=cacher.diaryNames[diaryNameId]
        const allDiarynames = Object.values(cacher.diaryNames)
        if (cacher.diaries[date]==undefined){
            cacher.diaries[date]={empty_diaries:allDiarynames};
        }
        const ind = cacher.emptyDiaries(date).indexOf(diaryName)
        console.log("removing on ind of ",date,diaryName)
        cacher.emptyDiaries(date).splice(ind,1)
        cacher.diaries[date][diaryName]=data



    },
    dateExists:function(date){
        return cacher.diaries[date]!=undefined
    },
    emptyDiaries:function(date){
        return cacher.diaries[date]["empty_diaries"]
    }

    
}

export { cacher}