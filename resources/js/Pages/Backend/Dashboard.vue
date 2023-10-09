<template>
       <div class="row q-col-gutter-md">
           <div class="col-xs-12">
               <ConstituencyChart/>
           </div>

           <div class="col-xs-12">
               <TradeChart/>
           </div>
           <div class="col-xs-12">
               <TradeDistrictLineChart/>
           </div>
       </div>
</template>
<script setup>
import TradeChart from "@/Components/TradeChart.vue";
import ConstituencyChart from "@/Components/ConstituencyChart.vue";
import TradeDistrictLineChart from "@/Components/TradeDistrictLineChart.vue";



</script>
