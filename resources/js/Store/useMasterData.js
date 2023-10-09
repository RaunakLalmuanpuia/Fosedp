import { defineStore } from 'pinia'

export const useMasterData = defineStore('masterData', {
    state: () => {
        return {
            districts:[],
            constituencies:[],
            departments:[],
            trades:[],
            subTrades:[]
        }
    },
    // could also be defined as
    // state: () => ({ count: 0 })
    actions: {
        fetchData(){
            axios.get(route('masterData.all'))
                .then(res=>{
                    const {districts,constituencies,departments, trades, subTrades} = res.data;
                    this.districts=districts
                    this.constituencies=constituencies
                    this.departments=departments
                    this.trades=trades
                    this.subTrades=subTrades
                })
                .catch(err=>{
                    console.log(err);
                    this.clearData()
                })
        },
        clearData() {
            this.departments = [];
            this.trades = [];
            this.subTrades = [];
        },
        getDistrictName(id) {
            const district = this.districts.find(item => item.id === id);
            return district?.name || 'NA'
        },
        getConstituencyName(id) {
            const temp = this.constituencies.find(item => item.id === id);
            return temp?.name || 'NA'
        },
        getDepartmentName(id) {
            const temp = this.departments.find(item => item.id === id);
            return temp?.name || 'NA'
        },
        getTradeName(id) {
            const temp = this.trades.find(item => item.id === id);
            return temp?.name || 'NA'
        },
        getSubtradeName(id) {
            const temp = this.subTrades.find(item => item.id === id);
            return temp?.name || 'NA'
        }

    },
})
