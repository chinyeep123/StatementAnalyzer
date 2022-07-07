<template>
    <tbody :id="moduleName + '-td-container'">
        <tr v-for="(statement, index) in statements" :id="moduleName + '_' + statement.id">
            <td :class="moduleName + '_col_checkbox checkitem'" :id="moduleName + '_col_checkbox_' + index">
                <!--list checkbox-->
                <span class="list-checkboxes display-inline-block w-px-20">
                    <input type="checkbox" :id="'listcheckbox-' + moduleName + '-' + statement.id" :name="'ids['+ statement.id +']'" :class="'listcheckbox listcheckbox-' + moduleName + ' filled-in chk-col-light-blue'" :data-actions-container-class="moduleName + '-checkbox-actions-container'">
                    <label :for="'listcheckbox-' + moduleName + '-' + statement.id"></label>
                </span>
            </td>
            <td :class="moduleName + '_col_account_number'" :id="moduleName + '_col_account_number_' + statement.id">
                {{ statement.account_number }}
            </td>
            <td :class="moduleName + '_col_date'" :id="moduleName + '_col_date_' + statement.id">
                {{ statement.date }}
            </td>
            <td :class="moduleName + '_col_description'" :id="moduleName + '_col_description_' + statement.id">
                {{ statement.description }}
            </td>
            <td :class="moduleName + '_col_debit_currency'" :id="moduleName + '_col_debit_currency_' + statement.id">
                {{ statement.debit_currency }}
            </td>
            <td :class="moduleName + '_col_debit'" :id="moduleName + '_col_debit_' + statement.id">
                {{ statement.debit }}
            </td>
            <td :class="moduleName + '_col_credit_currency'" :id="moduleName + '_col_credit_currency_' + statement.id">
                {{ statement.credit_currency }}
            </td>
            <td :class="moduleName + '_col_credit'" :id="moduleName + '_col_credit_' + statement.id">
                {{ statement.credit }}
            </td>
            <td :class="moduleName + '_col_balance_currency'" :id="moduleName + '_col_balance_currency_' + statement.id">
                {{ statement.balance_currency }}
            </td>
            <td :class="moduleName + '_col_balance'" :id="moduleName + '_col_balance_' + statement.id">
                {{ statement.balance }}
            </td>
            <td :class="moduleName + '_col_action actions_column'" :id="moduleName + '_col_action_' + statement.id">
                <!--action button-->
                <span class="list-table-action dropdown font-size-inherit">

                    <!--client options-->
                    <!--delete-->
                    <button type="button" title="Delete" class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger" :data-confirm-title="'Delete '+ startToUpper(moduleName)" data-confirm-text="Are you sure?" data-ajax-type="DELETE" :data-url="getURL(`/${statement.id}`)">
                        <i class="sl-icon-trash"></i>
                    </button>
                    <!--edit-->
                    <a href="javascript:void(0)" title="Edit" class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm" @click.stop="$emit('show-edit', {id:'statement-modal', data: statement})">
                        <i class="sl-icon-note"></i>
                    </a>
                </span>
                <!--action button-->
            </td>
        </tr>
    </tbody>
</template>

<script>
import Form from './Form.vue';
import _ from 'lodash';
export default {
    name: 'TableRows',
    components: {
        Form
    },
    props: {
        moduleName: {
            type: String,
            required: true,
        },
        statements: {
            type: Array,
            required: true,
        },
        url: {
            type: String,
            required: true,
        },
    },
    data() {
      return {
      };
    },
    methods: {
        getURL(string) {
            return `${this.url}/${this.moduleName}${string}`;
        },
        startToUpper(string) {
            return _.startCase(string);
        },
    }
}
</script>