import {date} from "quasar";

export default function () {
    const formatMoney = value => {
        return (new Intl.NumberFormat('en-IN', {style: 'currency', currency: 'INR'}).format(Number(value)));
    }

    const formatDate = (value, pattern) => {
        try {
            if (pattern) {
                return date.formatDate(new Date(value), pattern);
            }
            return date.formatDate(new Date(value), 'DD MMM YYYY');
        } catch (er) {
            return 'invalid Date'
        }
    }

    const formatDateTime = value => {
        try {
            return date.formatDate(new Date(value), 'DD MMM YYYY hh:mm a')
        } catch (er) {
            return 'invalid Date'
        }
    }
    const OFFICES_LEVELS=[
        {value:1,label:'Directorate/Head'},
        {value:2,label:'District'},
    ]
    const APPLICATION_STATUSES = ['submitted','verified','approved','ready'];

    const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const mobileRegex = /^[0-9]{10}$/;
    const randomizeColor=(length=5)=>{
        const COLORS=['#703131','#2f5f1a','#ae9966','#681bd7','#703131','#703131','#fff','#333','#f6f6f6','#5010ab','#ae9966','#5010ab','#ae9966']

        return COLORS[Math.random()*length]
    }
    return {
        formatMoney,
        formatDate,
        formatDateTime,
        emailRegex,
        mobileRegex,
        OFFICES_LEVELS,
        APPLICATION_STATUSES,
        randomizeColor
    }
};
