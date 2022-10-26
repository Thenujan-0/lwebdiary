let dateHandler ={
    all(){
        let dates= [];
        $(".btnDate").each(function(_,elem){
            dates.push(elem.innerHTML)
        })
        return dates;
    },

    /**
    *Returns the date above and below the selected date (returns 5 dates below selected)  */
    findDatesNearby(targetDate){
        let dates=this.all()
        let count = 5
        let ind = dates.indexOf(targetDate)
        let startInd =ind-count
        if (ind<=count){
            startInd=0
        }
        dates =dates.slice(startInd,ind+count)
        return dates

    }
}


let cacher ={
    fake:true,
    diaryNames:{}, //Contains diaryNameIds and their diaryNames
    diaries: {},//{date:{diary_name:data,empty_diaries:[]}}
    init(diaryNames,diaries){
        this.diaryNames=diaryNames
        if(diaries!= undefined){
            this.diaries = diaries
        }
    },

    /**Adds data to cache 
    * @param date
    * @param diaryNameId
    * @param data
    */
    add(date, diaryNameId,data){
        /* Here , data is a dictionary which contains diaryNameIds and diary data */
        // console.log(this.diaries,"this",this.diaryNames)
        let diaryName=this.diaryNames[diaryNameId]
        const allDiarynames = Object.values(this.diaryNames)

        if (!this.dateExists(date)){
            this.diaries[date]={empty_diaries:allDiarynames};
        }

        //Remove this diaryName from emptyDiaries
        const ind = this.emptyDiaries(date).indexOf(diaryName)
        this.emptyDiaries(date).splice(ind,1)
        
        this.diaries[date][diaryName]=data



    },
    dateExists(date){
        return this.diaries[date]!=undefined
    },
    emptyDiaries(date){
        return this.diaries[date].empty_diaries
    },
    cacheDates(datesToQuery){
        if (datesToQuery.length==0){
            return;
        }
        return $.post("/getDiaryDatas",{dates:datesToQuery,_token:token},function(resp){
            // console.log(resp)
            let json = JSON.parse(resp)
            json.forEach(elem => {
                // console.log("elem",elem)
                cacher.add(elem.date,
                        elem.diary_name_id,
                        elem.data)
            });
        })
    },
    cacheNearByDates(targetDate){
        let datesToQuery = dateHandler.findDatesNearby(targetDate)

        //Remove the dates that exist in cache
        let datesInCache = Object.keys(cacher.diaries)
        datesToQuery = datesToQuery.filter(function(elem){
            return !datesInCache.includes(elem)
                
        })

        return this.cacheDates(datesToQuery)
    },
    
}

export { cacher}