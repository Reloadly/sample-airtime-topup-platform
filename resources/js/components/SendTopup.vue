<template>
        <div class="card-content">
            <div class="card-body">
                <loading :active.sync="isLoading"
                         :can-cancel="false"
                         loader="dots"
                         :height="7"
                         :is-full-page="false"></loading>

                <div class="row justify-content-center align-items-center pb-1">
                    <label>Number</label>
                    <div class="pr-1 pl-1">
                        <input type="tel" id="number" class="form-control required" name="number" value="" v-model="selectedNumber" @keyup.enter="ValidateNumber()" required>
                    </div>
                    <div v-if="(detected===false)" >
                        <button class="btn btn-xs btn-icon btn-outline-primary mr-1 waves-effect waves-light" @click="ValidateNumber()"><i class="feather icon-arrow-right"></i></button>
                    </div>
                </div>
                <div v-if="(detected===false)" class="row" style="height:150px" >
                </div>

                <div v-if="detected">
                    <div class="row justify-content-center align-items-center">
                        <label>Operator</label>
                        <div class=" pl-1 pr-1">
                            <select style="width: 261px" class="custom-select form-control required" id="operator" name="operator" v-model="selectedOperator">
                                <option v-for="operator in operators" :value="operator">{{ operator.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center" v-if="selectedOperator.supports_local_amounts">
                        <ul class="nav nav-tabs nav-fill pr-1 pl-1" role="tablist">
                            <li class="nav-item">
                                <a v-bind:class="[isLocalTransfer?'':'active']" class="nav-link" data-toggle="tab" href="#international_transfers" role="tab" aria-controls="international_transfers" aria-selected="false" @click="transferModeChange(1)">International Transfer</a>
                            </li>
                            <li class="nav-item" v-if="selectedOperator.supports_local_amounts">
                                <a v-bind:class="[isLocalTransfer?'active':'']" class="nav-link" data-toggle="tab" href="#local_transfers" role="tab" aria-controls="local_transfers" aria-selected="true" @click="transferModeChange(0)">Local Transfer</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div v-bind:class="[isLocalTransfer?'':'active']" class="tab-pane" id="international_transfers" role="tabpanel" aria-labelledby="home-tab-fill">
                            <div class="row justify-content-center align-items-center">
                                <p>
                                    Fx Rate : <span id="fx_rate">{{ selectedOperator.fx_rate + " / " + selectedOperator.sender_currency_code }}</span><br>
                                    Estimate Sending Amount : <span id="sending_amount">{{ (amount * selectedOperator.fx_rate).toFixed(2) + " " + selectedOperator.destination_currency_code }}</span>
                                </p>
                            </div>
                            <div v-bind:class="[selectedOperator.denomination_type === 'RANGE'?'d-none':'']">
                                <div class="row justify-content-center align-items-center">
                                    <label>Amount</label>
                                    <div class="pr-1 pl-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select class="custom-select form-control">
                                                    <option>{{ selectedOperator.sender_currency_code }}</option>
                                                </select>
                                            </div>
                                            <select class="custom-select form-control required" id="select_amount" name="amount" v-model="amount">
                                                <option v-for="amount in selectedOperator.fixed_amounts" :value="amount">{{ amount + " " + selectedOperator.sender_currency_code }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center pb-1" v-bind:class="[selectedOperator.denomination_type === 'RANGE'?'':'d-none']">
                                <label> <b>Min : {{ selectedOperator.min_amount }} <br>Max : {{ selectedOperator.max_amount }}</b></label>
                                <div class="pr-1 pl-1">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select class="custom-select form-control">
                                                <option>{{ selectedOperator.sender_currency_code }}</option>
                                            </select>
                                        </div>
                                        <input type="number" step="any" :min="selectedOperator.min_amount" :max="selectedOperator.max_amount" class="form-control required" id="text_amount" name="amount" v-model="amount">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-bind:class="[isLocalTransfer?'active':'']" class="tab-pane" id="local_transfers" role="tabpanel" aria-labelledby="home-tab-fill" v-if="selectedOperator.supports_local_amounts">
                            <div v-bind:class="[selectedOperator.denomination_type === 'RANGE'?'d-none':'']">
                                <div class="row justify-content-center align-items-center">
                                    <label>Amount</label>
                                    <div class="pr-1 pl-1">
                                        <select class="custom-select form-control required" name="amount" v-model="localAmount">
                                            <option v-for="amount in selectedOperator.local_fixed_amounts" :value="amount">{{ amount + " " + selectedOperator.destination_currency_code }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center pb-1" v-bind:class="[selectedOperator.denomination_type === 'RANGE'?'':'d-none']">
                                <label> <b>Min : {{ selectedOperator.local_min_amount }} <br>Max : {{ selectedOperator.local_max_amount }}</b></label>
                                <div class="pr-1 pl-1">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >{{ selectedOperator.destination_currency_code }}</span>
                                        </div>
                                        <input type="number" step="any" :min="selectedOperator.local_min_amount" :max="selectedOperator.local_max_amount" class="form-control required" v-model="localAmount">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center mb-1">
                        <button class="btn btn-primary" @click="handleComplete()">Send</button>
                    </div>
                </div>
            </div>
        </div>

</template>

<style>
.input-group .input-group-prepend select{
    border-bottom-right-radius: 0;
    border-top-right-radius: 0;
}
</style>

<script>
import {FormWizard, TabContent} from 'vue-form-wizard';
import Loading from 'vue-loading-overlay';
export default {
    props: ['int_input', 'token'],
    data() {
        return {
            countries : [{"id":1,"iso":"AF","name":"Afghanistan","currency_code":"AFN","currency_name":"Afghan Afghani","currency_symbol":"\u060b","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/af.svg"},{"id":2,"iso":"AL","name":"Albania","currency_code":"ALL","currency_name":"Albanian Lek","currency_symbol":"Lek","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/al.svg"},{"id":3,"iso":"DZ","name":"Algeria","currency_code":"DZD","currency_name":"Algerian Dinar","currency_symbol":"\u062f.\u062c.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/dz.svg"},{"id":4,"iso":"AS","name":"American Samoa","currency_code":"USD","currency_name":"US Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/as.svg"},{"id":5,"iso":"AO","name":"Angola","currency_code":"AOA","currency_name":"Angolan Kwanza","currency_symbol":"AOA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ao.svg"},{"id":6,"iso":"AI","name":"Anguilla","currency_code":"XCD","currency_name":"East Caribbean Dollar","currency_symbol":"XCD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ai.svg"},{"id":7,"iso":"AG","name":"Antigua and Barbuda","currency_code":"XCD","currency_name":"East Caribbean Dollar","currency_symbol":"XCD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ag.svg"},{"id":8,"iso":"AR","name":"Argentina","currency_code":"ARS","currency_name":"Argentine Peso","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ar.svg"},{"id":9,"iso":"AM","name":"Armenia","currency_code":"AMD","currency_name":"Armenian Dram","currency_symbol":"\u0564\u0580.","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/am.svg"},{"id":10,"iso":"AW","name":"Aruba","currency_code":"AWG","currency_name":"Aruban Florin","currency_symbol":"AWG","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/aw.svg"},{"id":11,"iso":"BS","name":"Bahamas","currency_code":"BSD","currency_name":"Bahamian Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/bs.svg"},{"id":12,"iso":"BH","name":"Bahrain","currency_code":"BHD","currency_name":"Bahraini Dinar","currency_symbol":"\u062f.\u0628.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/bh.svg"},{"id":13,"iso":"BD","name":"Bangladesh","currency_code":"BDT","currency_name":"Bangladeshi Taka","currency_symbol":"\u09f3","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/bd.svg"},{"id":14,"iso":"BB","name":"Barbados","currency_code":"BBD","currency_name":"Barbadian Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/bb.svg"},{"id":15,"iso":"BZ","name":"Belize","currency_code":"BZD","currency_name":"Belize Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/bz.svg"},{"id":16,"iso":"BJ","name":"Benin","currency_code":"XOF","currency_name":"CFA Franc BCEAO","currency_symbol":"CFA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/bj.svg"},{"id":17,"iso":"BM","name":"Bermuda","currency_code":"BMD","currency_name":"Bermudan Dollar","currency_symbol":"BMD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/bm.svg"},{"id":18,"iso":"BO","name":"Bolivia","currency_code":"BOB","currency_name":"Bolivian Boliviano","currency_symbol":"Bs","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/bo.svg"},{"id":19,"iso":"BW","name":"Botswana","currency_code":"BWP","currency_name":"Botswanan Pula","currency_symbol":"P","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/bw.svg"},{"id":20,"iso":"BR","name":"Brazil","currency_code":"BRL","currency_name":"Brazilian Real","currency_symbol":"R$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/br.svg"},{"id":21,"iso":"VG","name":"British Virgin Islands","currency_code":"USD","currency_name":"US Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/vg.svg"},{"id":22,"iso":"BF","name":"Burkina Faso","currency_code":"XOF","currency_name":"CFA Franc BCEAO","currency_symbol":"CFA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/bf.svg"},{"id":23,"iso":"BI","name":"Burundi","currency_code":"BIF","currency_name":"Burundian Franc","currency_symbol":"FBu","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/bi.svg"},{"id":24,"iso":"KH","name":"Cambodia","currency_code":"KHR","currency_name":"Cambodian Riel","currency_symbol":"\u17db","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/kh.svg"},{"id":25,"iso":"CM","name":"Cameroon","currency_code":"XAF","currency_name":"CFA Franc BEAC","currency_symbol":"FCFA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/cm.svg"},{"id":26,"iso":"CA","name":"Canada","currency_code":"CAD","currency_name":"Canadian Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ca.svg"},{"id":27,"iso":"CV","name":"Cape Verde","currency_code":"CVE","currency_name":"Cape Verdean Escudo","currency_symbol":"CV$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/cv.svg"},{"id":28,"iso":"KY","name":"Cayman Islands","currency_code":"KYD","currency_name":"Cayman Islands Dollar","currency_symbol":"KYD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ky.svg"},{"id":29,"iso":"CF","name":"Central African Republic","currency_code":"XAF","currency_name":"CFA Franc BEAC","currency_symbol":"FCFA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/cf.svg"},{"id":30,"iso":"CL","name":"Chile","currency_code":"CLP","currency_name":"Chilean Peso","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/cl.svg"},{"id":31,"iso":"CN","name":"China","currency_code":"CNY","currency_name":"Chinese Yuan","currency_symbol":"CN\u00a5","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/cn.svg"},{"id":32,"iso":"CO","name":"Colombia","currency_code":"COP","currency_name":"Colombian Peso","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/co.svg"},{"id":33,"iso":"CG","name":"Congo","currency_code":"XAF","currency_name":"CFA Franc BEAC","currency_symbol":"FCFA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/cg.svg"},{"id":34,"iso":"CR","name":"Costa Rica","currency_code":"CRC","currency_name":"Costa Rican Col\u00f3n","currency_symbol":"\u20a1","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/cr.svg"},{"id":35,"iso":"CI","name":"C\u00f4te d'Ivoire","currency_code":"XOF","currency_name":"CFA Franc BCEAO","currency_symbol":"CFA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ci.svg"},{"id":36,"iso":"CU","name":"Cuba","currency_code":"CUP","currency_name":"Cuban Peso","currency_symbol":"\u20b1","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/cu.svg"},{"id":37,"iso":"CY","name":"Cyprus","currency_code":"EUR","currency_name":"Euro","currency_symbol":"\u20ac","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/cy.svg"},{"id":38,"iso":"DM","name":"Dominica","currency_code":"XCD","currency_name":"East Caribbean Dollar","currency_symbol":"XCD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/dm.svg"},{"id":39,"iso":"DO","name":"Dominican Republic","currency_code":"DOP","currency_name":"Dominican Peso","currency_symbol":"RD$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/do.svg"},{"id":40,"iso":"EC","name":"Ecuador","currency_code":"USD","currency_name":"US Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ec.svg"},{"id":41,"iso":"EG","name":"Egypt","currency_code":"EGP","currency_name":"Egyptian Pound","currency_symbol":"\u062c.\u0645.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/eg.svg"},{"id":42,"iso":"SV","name":"El Salvador","currency_code":"USD","currency_name":"US Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/sv.svg"},{"id":43,"iso":"ET","name":"Ethiopia","currency_code":"ETB","currency_name":"Ethiopian Birr","currency_symbol":"Br","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/et.svg"},{"id":44,"iso":"FJ","name":"Fiji","currency_code":"FJD","currency_name":"Fijian Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/fj.svg"},{"id":45,"iso":"FR","name":"France","currency_code":"EUR","currency_name":"Euro","currency_symbol":"\u20ac","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/fr.svg"},{"id":46,"iso":"GM","name":"Gambia","currency_code":"GMD","currency_name":"Gambian Dalasi","currency_symbol":"GMD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/gm.svg"},{"id":47,"iso":"GE","name":"Georgia","currency_code":"GEL","currency_name":"Georgian Lari","currency_symbol":"\u10da","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ge.svg"},{"id":48,"iso":"DE","name":"Germany","currency_code":"EUR","currency_name":"Euro","currency_symbol":"\u20ac","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/de.svg"},{"id":49,"iso":"GH","name":"Ghana","currency_code":"GHS","currency_name":"Ghanaian Cedi","currency_symbol":"GH\u20b5","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/gh.svg"},{"id":50,"iso":"GD","name":"Grenada","currency_code":"XCD","currency_name":"East Caribbean Dollar","currency_symbol":"XCD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/gd.svg"},{"id":51,"iso":"GT","name":"Guatemala","currency_code":"GTQ","currency_name":"Guatemalan Quetzal","currency_symbol":"Q","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/gt.svg"},{"id":52,"iso":"GN","name":"Guinea Conakry","currency_code":"GNF","currency_name":"Guinean Franc","currency_symbol":"FG","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/gn.svg"},{"id":53,"iso":"GW","name":"Guinea-Bissau","currency_code":"XOF","currency_name":"CFA Franc BCEAO","currency_symbol":"CFA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/gw.svg"},{"id":54,"iso":"GY","name":"Guyana","currency_code":"GYD","currency_name":"Guyanaese Dollar","currency_symbol":"GYD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/gy.svg"},{"id":55,"iso":"HT","name":"Haiti","currency_code":"HTG","currency_name":"Haitian Gourde","currency_symbol":"HTG","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ht.svg"},{"id":56,"iso":"HN","name":"Honduras","currency_code":"HNL","currency_name":"Honduran Lempira","currency_symbol":"L","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/hn.svg"},{"id":57,"iso":"IN","name":"India","currency_code":"INR","currency_name":"Indian Rupee","currency_symbol":"\u20b9","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/in.svg"},{"id":58,"iso":"ID","name":"Indonesia","currency_code":"IDR","currency_name":"Indonesian Rupiah","currency_symbol":"Rp","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/id.svg"},{"id":59,"iso":"IQ","name":"Iraq","currency_code":"IQD","currency_name":"Iraqi Dinar","currency_symbol":"\u062f.\u0639.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/iq.svg"},{"id":60,"iso":"IT","name":"Italy","currency_code":"EUR","currency_name":"Euro","currency_symbol":"\u20ac","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/it.svg"},{"id":61,"iso":"JM","name":"Jamaica","currency_code":"JMD","currency_name":"Jamaican Dollar","currency_symbol":"J$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/jm.svg"},{"id":62,"iso":"JO","name":"Jordan","currency_code":"JOD","currency_name":"Jordanian Dinar","currency_symbol":"\u062f.\u0623.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/jo.svg"},{"id":63,"iso":"KZ","name":"Kazakhstan","currency_code":"KZT","currency_name":"Kazakhstani Tenge","currency_symbol":"\u0442\u04a3\u0433.","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/kz.svg"},{"id":64,"iso":"KE","name":"Kenya","currency_code":"KES","currency_name":"Kenyan Shilling","currency_symbol":"Ksh","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ke.svg"},{"id":65,"iso":"KW","name":"Kuwait","currency_code":"KWD","currency_name":"Kuwaiti Dinar","currency_symbol":"\u062f.\u0643.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/kw.svg"},{"id":66,"iso":"KG","name":"Kyrgyzstan","currency_code":"KGS","currency_name":"Kyrgystani Som","currency_symbol":"KGS","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/kg.svg"},{"id":67,"iso":"LA","name":"Laos","currency_code":"LAK","currency_name":"Laotian Kip","currency_symbol":"LAK","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/la.svg"},{"id":68,"iso":"LB","name":"Lebanon","currency_code":"LBP","currency_name":"Lebanese Pound","currency_symbol":"\u0644.\u0644.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/lb.svg"},{"id":69,"iso":"LR","name":"Liberia","currency_code":"USD","currency_name":"US Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/lr.svg"},{"id":70,"iso":"MK","name":"Macedonia","currency_code":"MKD","currency_name":"Macedonian Denar","currency_symbol":"MKD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/mk.svg"},{"id":71,"iso":"MG","name":"Madagascar","currency_code":"MGA","currency_name":"Malagasy Ariary","currency_symbol":"MGA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/mg.svg"},{"id":72,"iso":"MW","name":"Malawi","currency_code":"MWK","currency_name":"Malawian Kwacha","currency_symbol":"MWK","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/mw.svg"},{"id":73,"iso":"MY","name":"Malaysia","currency_code":"MYR","currency_name":"Malaysian Ringgit","currency_symbol":"RM","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/my.svg"},{"id":74,"iso":"ML","name":"Mali","currency_code":"XOF","currency_name":"CFA Franc BCEAO","currency_symbol":"CFA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ml.svg"},{"id":75,"iso":"MQ","name":"Martinique","currency_code":"EUR","currency_name":"Euro","currency_symbol":"\u20ac","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/mq.svg"},{"id":76,"iso":"MX","name":"Mexico","currency_code":"MXN","currency_name":"Mexican Peso","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/mx.svg"},{"id":77,"iso":"MD","name":"Moldova","currency_code":"MDL","currency_name":"Moldovan Leu","currency_symbol":"MDL","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/md.svg"},{"id":78,"iso":"MA","name":"Morocco","currency_code":"MAD","currency_name":"Moroccan Dirham","currency_symbol":"\u062f.\u0645.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ma.svg"},{"id":79,"iso":"MZ","name":"Mozambique","currency_code":"MZN","currency_name":"Mozambican Metical","currency_symbol":"MTn","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/mz.svg"},{"id":80,"iso":"MM","name":"Myanmar","currency_code":"MMK","currency_name":"Myanma Kyat","currency_symbol":"K","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/mm.svg"},{"id":81,"iso":"NA","name":"Namibia","currency_code":"NAD","currency_name":"Namibian Dollar","currency_symbol":"N$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/na.svg"},{"id":82,"iso":"NR","name":"Nauru","currency_code":"AUD","currency_name":"Australian Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/nr.svg"},{"id":83,"iso":"NP","name":"Nepal","currency_code":"NPR","currency_name":"Nepalese Rupee","currency_symbol":"\u0928\u0947\u0930\u0942","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/np.svg"},{"id":84,"iso":"NL","name":"Netherlands","currency_code":"EUR","currency_name":"Euro","currency_symbol":"\u20ac","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/nl.svg"},{"id":85,"iso":"AN","name":"Netherlands Antilles","currency_code":"ANG","currency_name":"Netherlands Antillean Guilder","currency_symbol":"\u0192","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ant.svg\n"},{"id":86,"iso":"NI","name":"Nicaragua","currency_code":"NIO","currency_name":"Nicaraguan C\u00f3rdoba","currency_symbol":"C$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ni.svg"},{"id":87,"iso":"NE","name":"Niger","currency_code":"XOF","currency_name":"CFA Franc BCEAO","currency_symbol":"CFA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ne.svg"},{"id":88,"iso":"NG","name":"Nigeria","currency_code":"NGN","currency_name":"Nigerian Naira","currency_symbol":"\u20a6","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ng.svg"},{"id":89,"iso":"OM","name":"Oman","currency_code":"OMR","currency_name":"Omani Rial","currency_symbol":"\u0631.\u0639.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/om.svg"},{"id":90,"iso":"PK","name":"Pakistan","currency_code":"PKR","currency_name":"Pakistani Rupee","currency_symbol":"\u20a8","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/pk.svg"},{"id":91,"iso":"PS","name":"Palestine","currency_code":"ILS","currency_name":"Israeli New Sheqel","currency_symbol":"\u20aa","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ps.svg"},{"id":92,"iso":"PA","name":"Panama","currency_code":"PAB","currency_name":"Panamanian Balboa","currency_symbol":"B\/.","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/pa.svg"},{"id":93,"iso":"PG","name":"Papua New Guinea","currency_code":"PGK","currency_name":"Papua New Guinean Kina","currency_symbol":"PGK","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/pg.svg"},{"id":94,"iso":"PY","name":"Paraguay","currency_code":"PYG","currency_name":"Paraguayan Guarani","currency_symbol":"\u20b2","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/py.svg"},{"id":95,"iso":"PE","name":"Peru","currency_code":"PEN","currency_name":"Peruvian Nuevo Sol","currency_symbol":"S\/.","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/pe.svg"},{"id":96,"iso":"PH","name":"Philippines","currency_code":"PHP","currency_name":"Philippine Peso","currency_symbol":"\u20b1","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ph.svg"},{"id":97,"iso":"PL","name":"Poland","currency_code":"PLN","currency_name":"Polish Zloty","currency_symbol":"z\u0142","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/pl.svg"},{"id":98,"iso":"PT","name":"Portugal","currency_code":"EUR","currency_name":"Euro","currency_symbol":"\u20ac","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/pt.svg"},{"id":99,"iso":"PR","name":"Puerto Rico","currency_code":"USD","currency_name":"US Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/pr.svg"},{"id":100,"iso":"QA","name":"Qatar","currency_code":"QAR","currency_name":"Qatari Rial","currency_symbol":"\u0631.\u0642.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/qa.svg"},{"id":101,"iso":"RO","name":"Romania","currency_code":"RON","currency_name":"Romanian Leu","currency_symbol":"lei","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ro.svg"},{"id":102,"iso":"RU","name":"Russia","currency_code":"RUB","currency_name":"Russian Ruble","currency_symbol":"\u0440\u0443\u0431.","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ru.svg"},{"id":103,"iso":"RW","name":"Rwanda","currency_code":"RWF","currency_name":"Rwandan Franc","currency_symbol":"FR","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/rw.svg"},{"id":104,"iso":"KN","name":"Saint Kitts And Nevis","currency_code":"XCD","currency_name":"East Caribbean Dollar","currency_symbol":"XCD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/kn.svg"},{"id":105,"iso":"LC","name":"Saint Lucia","currency_code":"XCD","currency_name":"East Caribbean Dollar","currency_symbol":"XCD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/lc.svg"},{"id":106,"iso":"VC","name":"Saint Vincent And The Grenadines","currency_code":"XCD","currency_name":"East Caribbean Dollar","currency_symbol":"XCD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/vc.svg"},{"id":107,"iso":"WS","name":"Samoa","currency_code":"WST","currency_name":"Samoan Tala","currency_symbol":"WST","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ws.svg"},{"id":108,"iso":"SA","name":"Saudi Arabia","currency_code":"SAR","currency_name":"Saudi Riyal","currency_symbol":"\u0631.\u0633.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/sa.svg"},{"id":109,"iso":"SN","name":"Senegal","currency_code":"XOF","currency_name":"CFA Franc BCEAO","currency_symbol":"CFA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/sn.svg"},{"id":110,"iso":"SL","name":"Sierra Leone","currency_code":"SLL","currency_name":"Sierra Leonean Leone","currency_symbol":"SLL","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/sl.svg"},{"id":111,"iso":"SG","name":"Singapore","currency_code":"SGD","currency_name":"Singapore Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/sg.svg"},{"id":112,"iso":"ZA","name":"South Africa","currency_code":"ZAR","currency_name":"South African Rand","currency_symbol":"R","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/za.svg"},{"id":113,"iso":"ES","name":"Spain","currency_code":"EUR","currency_name":"Euro","currency_symbol":"\u20ac","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/es.svg"},{"id":114,"iso":"LK","name":"Sri Lanka","currency_code":"LKR","currency_name":"Sri Lankan Rupee","currency_symbol":"SL Re","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/lk.svg"},{"id":115,"iso":"SR","name":"Suriname","currency_code":"SRD","currency_name":"Surinamese Dollar","currency_symbol":"SRD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/sr.svg"},{"id":116,"iso":"SZ","name":"Swaziland","currency_code":"SZL","currency_name":"Swazi Lilangeni","currency_symbol":"SZL","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/sz.svg"},{"id":117,"iso":"TJ","name":"Tajikistan","currency_code":"TJS","currency_name":"Tajikistani Somoni","currency_symbol":"TJS","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/tj.svg"},{"id":118,"iso":"TZ","name":"Tanzania","currency_code":"TZS","currency_name":"Tanzanian Shilling","currency_symbol":"TSh","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/tz.svg"},{"id":119,"iso":"TH","name":"Thailand","currency_code":"THB","currency_name":"Thai Baht","currency_symbol":"\u0e3f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/th.svg"},{"id":120,"iso":"CD","name":"The Democratic Republic Of Congo","currency_code":"CDF","currency_name":"Congolese Franc","currency_symbol":"FrCD","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/cd.svg"},{"id":121,"iso":"TG","name":"Togo","currency_code":"XOF","currency_name":"CFA Franc BCEAO","currency_symbol":"CFA","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/tg.svg"},{"id":122,"iso":"TO","name":"Tonga","currency_code":"TOP","currency_name":"Tongan Pa?anga","currency_symbol":"T$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/to.svg"},{"id":123,"iso":"TT","name":"Trinidad and Tobago","currency_code":"TTD","currency_name":"Trinidad and Tobago Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/tt.svg"},{"id":124,"iso":"TN","name":"Tunisia","currency_code":"TND","currency_name":"Tunisian Dinar","currency_symbol":"\u062f.\u062a.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/tn.svg"},{"id":125,"iso":"TR","name":"Turkey","currency_code":"TRY","currency_name":"Turkish Lira","currency_symbol":"TL","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/tr.svg"},{"id":126,"iso":"TC","name":"Turks And Caicos Islands","currency_code":"USD","currency_name":"US Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/tc.svg"},{"id":127,"iso":"UG","name":"Uganda","currency_code":"UGX","currency_name":"Ugandan Shilling","currency_symbol":"USh","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ug.svg"},{"id":128,"iso":"UA","name":"Ukraine","currency_code":"UAH","currency_name":"Ukrainian Hryvnia","currency_symbol":"\u20b4","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ua.svg"},{"id":129,"iso":"AE","name":"United Arab Emirates","currency_code":"AED","currency_name":"United Arab Emirates Dirham","currency_symbol":"\u062f.\u0625.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ae.svg"},{"id":130,"iso":"GB","name":"United Kingdom","currency_code":"GBP","currency_name":"British Pound Sterling","currency_symbol":"\u00a3","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/gb.svg"},{"id":131,"iso":"US","name":"United States","currency_code":"USD","currency_name":"US Dollar","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/us.svg"},{"id":132,"iso":"UY","name":"Uruguay","currency_code":"UYU","currency_name":"Uruguayan Peso","currency_symbol":"$","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/uy.svg"},{"id":133,"iso":"UZ","name":"Uzbekistan","currency_code":"UZS","currency_name":"Uzbekistan Som","currency_symbol":"UZS","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/uz.svg"},{"id":134,"iso":"VU","name":"Vanuatu","currency_code":"VUV","currency_name":"Vanuatu Vatu","currency_symbol":"VUV","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/vu.svg"},{"id":135,"iso":"VN","name":"Vietnam","currency_code":"VND","currency_name":"Vietnamese Dong","currency_symbol":"\u20ab","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/vn.svg"},{"id":136,"iso":"YE","name":"Yemen","currency_code":"YER","currency_name":"Yemeni Rial","currency_symbol":"\u0631.\u064a.\u200f","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ye.svg"},{"id":137,"iso":"ZM","name":"Zambia","currency_code":"ZMW","currency_name":"ZMW","currency_symbol":"ZMW","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/zm.svg"},{"id":138,"iso":"ZW","name":"Zimbabwe","currency_code":"ZWL","currency_name":"Zimbabwean Dollar (2009)","currency_symbol":"ZWL","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/zw.svg"},{"id":139,"iso":"VE","name":"Venezuela","currency_code":"VEF","currency_name":"Bolivar Fuerte","currency_symbol":"Bs.F.","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/ve.svg"},{"id":140,"iso":"GR","name":"Greece","currency_code":"EUR","currency_name":"Euro","currency_symbol":"\u20ac","flag":"https:\/\/s3.amazonaws.com\/rld-flags\/gr.svg"}],
            selectedCountry : null,
            selectedNumber : null,
            selectedFile : null,
            isLoading: false,
            operators: [{"id":4,"rid":"1","country_id":1,"name":"Afghan Wireless Afghanistan","bundle":"0","data":0,"pin":0,"supports_local_amounts":0,"denomination_type":"RANGE","sender_currency_code":"CAD","sender_currency_symbol":"$","destination_currency_code":"AFN","destination_currency_symbol":"\u060b","commission":8,"international_discount":8,"local_discount":0,"most_popular_amount":25,"min_amount":1.04,"local_min_amount":null,"max_amount":103,"local_max_amount":null,"fx_rate":48.2406,"logo_urls":["https:\/\/s3.amazonaws.com\/rld-operator\/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-2.png","https:\/\/s3.amazonaws.com\/rld-operator\/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-3.png","https:\/\/s3.amazonaws.com\/rld-operator\/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-1.png"],"fixed_amounts":[],"fixed_amounts_descriptions":[],"local_fixed_amounts":[],"local_fixed_amounts_descriptions":[],"suggested_amounts":[2,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100],"suggested_amounts_map":{"2":111.63,"5":279.06,"10":558.12,"15":837.18,"20":1116.24,"25":1395.3,"30":1674.36,"35":1953.42,"40":2232.48,"45":2511.54,"50":2790.6,"55":3069.66,"60":3348.72,"65":3627.77,"70":3906.83,"75":4185.89,"80":4464.95,"85":4744.01,"90":5023.07,"95":5302.13,"100":5581.19},"created_at":"2020-06-05T11:15:41.000000Z","updated_at":"2020-06-05T11:15:41.000000Z","select_amounts":[2,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100]},{"id":164,"rid":"3","country_id":1,"name":"Etisalat Afghanistan","bundle":"0","data":0,"pin":0,"supports_local_amounts":0,"denomination_type":"RANGE","sender_currency_code":"CAD","sender_currency_symbol":"$","destination_currency_code":"AFN","destination_currency_symbol":"\u060b","commission":8,"international_discount":8,"local_discount":0,"most_popular_amount":25,"min_amount":0.03,"local_min_amount":null,"max_amount":103,"local_max_amount":null,"fx_rate":48.2406,"logo_urls":["https:\/\/s3.amazonaws.com\/rld-operator\/17d6e30d-2118-4bab-bf54-fd19742880c9-size-3.png","https:\/\/s3.amazonaws.com\/rld-operator\/17d6e30d-2118-4bab-bf54-fd19742880c9-size-2.png","https:\/\/s3.amazonaws.com\/rld-operator\/17d6e30d-2118-4bab-bf54-fd19742880c9-size-1.png"],"fixed_amounts":[],"fixed_amounts_descriptions":[],"local_fixed_amounts":[],"local_fixed_amounts_descriptions":[],"suggested_amounts":[1,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100],"suggested_amounts_map":{"1":55.82,"5":279.06,"10":558.12,"15":837.18,"20":1116.24,"25":1395.3,"30":1674.36,"35":1953.42,"40":2232.48,"45":2511.54,"50":2790.6,"55":3069.66,"60":3348.72,"65":3627.77,"70":3906.83,"75":4185.89,"80":4464.95,"85":4744.01,"90":5023.07,"95":5302.13,"100":5581.19},"created_at":"2020-06-05T11:15:49.000000Z","updated_at":"2020-06-05T11:15:49.000000Z","select_amounts":[1,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100]},{"id":295,"rid":"2","country_id":1,"name":"MTN Afghanistan","bundle":"0","data":0,"pin":0,"supports_local_amounts":0,"denomination_type":"RANGE","sender_currency_code":"CAD","sender_currency_symbol":"$","destination_currency_code":"AFN","destination_currency_symbol":"\u060b","commission":8,"international_discount":8,"local_discount":0,"most_popular_amount":25,"min_amount":0.22,"local_min_amount":null,"max_amount":85,"local_max_amount":null,"fx_rate":46.56583,"logo_urls":["https:\/\/s3.amazonaws.com\/rld-operator\/929e9c5c-a680-4968-9ffc-9b3924c61d9b-size-3.png","https:\/\/s3.amazonaws.com\/rld-operator\/929e9c5c-a680-4968-9ffc-9b3924c61d9b-size-2.png","https:\/\/s3.amazonaws.com\/rld-operator\/929e9c5c-a680-4968-9ffc-9b3924c61d9b-size-1.png"],"fixed_amounts":[],"fixed_amounts_descriptions":[],"local_fixed_amounts":[],"local_fixed_amounts_descriptions":[],"suggested_amounts":[1,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85],"suggested_amounts_map":{"1":55.82,"5":279.06,"10":558.12,"15":837.18,"20":1116.24,"25":1395.3,"30":1674.36,"35":1953.42,"40":2232.48,"45":2511.54,"50":2790.6,"55":3069.66,"60":3348.72,"65":3627.77,"70":3906.83,"75":4185.89,"80":4464.95,"85":4744.01},"created_at":"2020-06-05T11:16:20.000000Z","updated_at":"2020-06-05T11:16:20.000000Z","select_amounts":[1,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85]},{"id":392,"rid":"4","country_id":1,"name":"Roshan Afghanistan","bundle":"0","data":0,"pin":0,"supports_local_amounts":0,"denomination_type":"RANGE","sender_currency_code":"CAD","sender_currency_symbol":"$","destination_currency_code":"AFN","destination_currency_symbol":"\u060b","commission":8,"international_discount":8,"local_discount":0,"most_popular_amount":25,"min_amount":0.11,"local_min_amount":null,"max_amount":150,"local_max_amount":null,"fx_rate":46.56583,"logo_urls":["https:\/\/s3.amazonaws.com\/rld-operator\/3ef560fa-ee51-4a6e-851d-2874a29bdfa1-size-3.png","https:\/\/s3.amazonaws.com\/rld-operator\/3ef560fa-ee51-4a6e-851d-2874a29bdfa1-size-1.png","https:\/\/s3.amazonaws.com\/rld-operator\/3ef560fa-ee51-4a6e-851d-2874a29bdfa1-size-2.png"],"fixed_amounts":[],"fixed_amounts_descriptions":[],"local_fixed_amounts":[],"local_fixed_amounts_descriptions":[],"suggested_amounts":[1,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100,105,110,115,120,125,130,135,140,145,150],"suggested_amounts_map":{"1":55.82,"5":279.06,"10":558.12,"15":837.18,"20":1116.24,"25":1395.3,"30":1674.36,"35":1953.42,"40":2232.48,"45":2511.54,"50":2790.6,"55":3069.66,"60":3348.72,"65":3627.77,"70":3906.83,"75":4185.89,"80":4464.95,"85":4744.01,"90":5023.07,"95":5302.13,"100":5581.19,"105":5860.25,"110":6139.31,"115":6418.37,"120":6697.43,"125":6976.48,"130":7255.54,"135":7534.6,"140":7813.66,"145":8092.72,"150":8371.78},"created_at":"2020-06-05T11:16:25.000000Z","updated_at":"2020-06-05T11:16:25.000000Z","select_amounts":[1,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100,105,110,115,120,125,130,135,140,145,150]}],
            selectedOperator : {"id":4,"rid":"1","country_id":1,"name":"Afghan Wireless Afghanistan","bundle":"0","data":0,"pin":0,"supports_local_amounts":0,"denomination_type":"RANGE","sender_currency_code":"CAD","sender_currency_symbol":"$","destination_currency_code":"AFN","destination_currency_symbol":"\u060b","commission":8,"international_discount":8,"local_discount":0,"most_popular_amount":25,"min_amount":1.04,"local_min_amount":null,"max_amount":103,"local_max_amount":null,"fx_rate":48.2406,"logo_urls":["https:\/\/s3.amazonaws.com\/rld-operator\/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-2.png","https:\/\/s3.amazonaws.com\/rld-operator\/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-3.png","https:\/\/s3.amazonaws.com\/rld-operator\/b0c4d9d0-9feb-48ba-9a29-3f4a8bcd3268-size-1.png"],"fixed_amounts":[],"fixed_amounts_descriptions":[],"local_fixed_amounts":[],"local_fixed_amounts_descriptions":[],"suggested_amounts":[2,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100],"suggested_amounts_map":{"2":111.63,"5":279.06,"10":558.12,"15":837.18,"20":1116.24,"25":1395.3,"30":1674.36,"35":1953.42,"40":2232.48,"45":2511.54,"50":2790.6,"55":3069.66,"60":3348.72,"65":3627.77,"70":3906.83,"75":4185.89,"80":4464.95,"85":4744.01,"90":5023.07,"95":5302.13,"100":5581.19},"created_at":"2020-06-05T11:15:41.000000Z","updated_at":"2020-06-05T11:15:41.000000Z","select_amounts":[2,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100]},
            amount : 1.07,
            localAmount : 0.00,
            numbers : [],
            isLocalTransfer : false,
            detected: false,
            intInput: null
        }
    },
    methods: {
        handleComplete: function(){
            if (this.selectedOperator.denomination_type === 'RANGE' && (this.isLocalTransfer && (parseFloat(this.localAmount) < parseFloat(this.selectedOperator.local_min_amount) || parseFloat(this.localAmount) > parseFloat(this.selectedOperator.local_max_amount)) || (!this.isLocalTransfer && (parseFloat(this.amount) < parseFloat(this.minAmount) || parseFloat(this.amount) > parseFloat(this.maxAmount))))){
                toastr.error('Invalid Amount. Please enter within the min and max boundary');
                return;
            }
            this.isLoading = true;
            let token = this.token;
            let config = {
                headers: {Authorization: `Bearer ${token}`},
            };
            let bodyParameters = {
                '_token' : $('meta[name="csrf-token"]').attr('content'),
                'number' : this.selectedNumber,
                'file_id' : this.selectedFile,
                'operator' : this.selectedOperator.id,
                'is_local' : this.isLocalTransfer,
                'amount' : this.amount,
                'local_amount' : this.localAmount
            };
            axios
                .post('/topups/send', bodyParameters, config)
                .then(response => {
                    this.isLoading = false;
                    if (response.data.message)
                        toastr.success(response.data.message);
                    else if (response.data.error)
                        toastr.error(response.data.error);
                    if (response.data.location)
                        window.location = response.data.location;
                });
        },
        transferModeChange: function (isInternational) {
            this.isLocalTransfer = !isInternational;
        },
        handleErrorMessage: function(errorMsg){
            if (errorMsg)
                toastr.error(errorMsg);
        },
        ValidateCountry: function () {
            return new Promise((resolve, reject) => {
                if (this.selectedCountry){
                    let token = this.token;
                    let config = {
                        headers: {Authorization: `Bearer ${token}`},
                    };
                    axios
                        .get("/countries/" + this.selectedCountry + "/numbers", config)
                        .then(response => {
                            this.numbers = response.data;
                            resolve(true);
                        });
                }
                else
                    reject('Please Select Country to Proceed.');
            })
        },
        ValidateNumber: function () {
            if(this.selectedNumber) {
                return new Promise((resolve, reject) => {
                    if (!this.selectedNumber) reject('Please add Number to Proceed.');
                    let token = this.token;
                    let config = {
                        headers: {Authorization: `Bearer ${token}`},
                    };
                    axios
                        .get("/api/countries/" + this.selectedCountry + "/operators/detect/" + this.selectedNumber, config)
                        .then(response => {
                            if (response.data) {
                                let filteredOperator = this.operators.filter(X => X.id === response.data.id);
                                if(filteredOperator[0]) {
                                    this.selectedOperator = filteredOperator[0];
                                    toastr.success('Operator Found');
                                }else{
                                    this.selectedOperator = this.operators[0];
                                    toastr.error('Unable to auto-detect Operator');
                                }
                            } else {
                                this.selectedOperator = this.operators[0];
                                toastr.error('Unable to auto-detect Operator');
                            }
                            this.detected = true;
                            resolve(true);
                        });
                })
            }
        },
    },
    mounted() {
         this.intInput = window.intlTelInput(document.querySelector("#number"), {
            separateDialCode: true,
            utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js",
            preferredCountries: []
        });
        let token = this.token;
        let config = {
            headers: {Authorization: `Bearer ${token}`},
        };
        axios
            .get("/api/countries", config)
            .then(response => {
                this.countries = response.data;
                this.selectedCountry = this.countries[0].id;
                var countries = window.intlTelInputGlobals.getCountryData();
                countries.length = 0;
                var Temp = JSON.parse(this.int_input);
                $.each(Temp, function(i, country) {
                    countries.push(country);
                });
            });
        var $this=this;
        document.querySelector("#number").addEventListener("countrychange", function() {
            $this.selectedCountry = $this.intInput.getSelectedCountryData().id;
            $this.detected=false;
            let token = $this.token;
            let config = {
                headers: {Authorization: `Bearer ${token}`},
            };
            axios
                .get("/api/countries/"+$this.intInput.getSelectedCountryData().id+"/operators", config)
                .then(response => {
                    $this.operators = response.data;
                    $this.selectedOperator = $this.operators[0];
                });

        })
    },
    created() {

    }
    ,watch: {
        'selectedOperator': function (operator, oldVal) {
            this.isLocalTransfer = false;
        },
    },
    components: {
        FormWizard,
        TabContent,
        Loading
    }
}
</script>
