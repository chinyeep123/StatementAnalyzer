<template>
    <tbody :id="settings.module + '-td-container'">
        <tr v-for="(statement, index) in settings.statements.data" :id="settings.module + '_' + statement.id">
            <td :class="settings.module + '_col_checkbox checkitem'" :id="settings.module + '_col_checkbox_' + index">
                <!--list checkbox-->
                <span class="list-checkboxes display-inline-block w-px-20">
                    <input type="checkbox" :id="'listcheckbox-' + settings.module + '-' + statement.id" :name="'ids['+ statement.id +']'" :class="'listcheckbox listcheckbox-' + settings.module + ' filled-in chk-col-light-blue'" :data-actions-container-class="settings.module + '-checkbox-actions-container'">
                    <label :for="'listcheckbox-' + settings.module + '-' + statement.id"></label>
                </span>
            </td>
            <td :class="settings.module + '_col_account_number'" :id="settings.module + '_col_account_number_' + statement.id">
                {{ statement.account_number }}
            </td>
            <td :class="settings.module + '_col_date'" :id="settings.module + '_col_date_' + statement.id">
                {{ statement.date }}
            </td>
            <td :class="settings.module + '_col_description'" :id="settings.module + '_col_description_' + statement.id">
                {{ statement.description }}
            </td>
            <td :class="settings.module + '_col_money_in_currency'" :id="settings.module + '_col_money_in_currency_' + statement.id">
                {{ statement.money_in_currency }}
            </td>
            <td :class="settings.module + '_col_money_in'" :id="settings.module + '_col_money_in_' + statement.id">
                {{ statement.money_in }}
            </td>
            <td :class="settings.module + '_col_money_out_currency'" :id="settings.module + '_col_money_out_currency_' + statement.id">
                {{ statement.money_out_currency }}
            </td>
            <td :class="settings.module + '_col_money_out'" :id="settings.module + '_col_money_out_' + statement.id">
                {{ statement.money_out }}
            </td>
            <td :class="settings.module + '_col_balance_currency'" :id="settings.module + '_col_balance_currency_' + statement.id">
                {{ statement.balance_currency }}
            </td>
            <td :class="settings.module + '_col_balance'" :id="settings.module + '_col_balance_' + statement.id">
                {{ statement.balance }}
            </td>
            <td :class="settings.module + '_col_action actions_column'" :id="settings.module + '_col_action_' + statement.id">
                <!--action button-->
                <span class="list-table-action dropdown font-size-inherit">

                    <!--client options-->
                    <!--delete-->
                    <button type="button" title="Delete" class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger" :data-confirm-title="'Delete '+ startToUpper(settings.module)" data-confirm-text="Are you sure?" data-ajax-type="DELETE" :data-url="getURL(`/${statement.id}`)">
                        <i class="sl-icon-trash"></i>
                    </button>
                    <!--edit-->
                    <a href="javascript:void(0)" title="Edit" class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm" @click="$emit('on-edit', statement)">
                        <i class="sl-icon-note"></i>
                    </a>
                </span>
                <!--action button-->
            </td>
        </tr>
    </tbody>
</template>

<script>
import _ from 'lodash';
export default {
    name: 'TableRows',
    components: {
    },
    props: {
        settings: {
            type: Object,
            required: true,
        },
    },
    data() {
      return {
      };
    },
    methods: {
        getURL(string) {
            return `${this.settings.url}/${this.settings.module}${string}`;
        },
        startToUpper(string) {
            return _.startCase(string);
        }
    }
}
</script>