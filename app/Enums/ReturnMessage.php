<?php

namespace App\Enums;

enum ReturnMessage: string {
    case FAILED_TO_LOGIN        = 'Failed to login. Try again';

    case USER_CREATED_SUCCESS   = 'User created successfully';
    case USER_CREATED_FAIL      = 'Cannot create the user. Try again';
    case USER_UPDATED_SUCCESS   = 'User updated successfully';
    case USER_UPDATED_FAIL      = 'Cannot update the user. Try again';
    case USER_DELETED_SUCCESS   = 'User deleted successfully';
    case USER_DELETED_FAIL      = 'Cannot delete the user. Try again';

    case CUSTOMER_PHONE_INVALID     = 'The phone field contains an invalid number';
    case CUSTOMER_CREATED_SUCCESS   = 'Customer created successfully';
    case CUSTOMER_CREATED_FAIL      = 'Cannot create the customer. Try again';
    case CUSTOMER_UPDATED_SUCCESS   = 'Customer updated successfully';
    case CUSTOMER_UPDATED_FAIL      = 'Cannot update the customer. Try again';
    case CUSTOMER_DELETED_SUCCESS   = 'Customer deleted successfully';
    case CUSTOMER_DELETED_FAIL      = 'Cannot delete the customer. Try again';

    case SALE_CREATED_SUCCESS   = 'Sale created successfully for the customer';
    case SALE_CREATED_FAIL      = 'Cannot create the sale for the customer. Try again';

    case RECEIPT_PAID_SUCCESS   = 'The receipt of the customer was successfully paid';
    case RECEIPT_PAID_FAIL      = 'Cannot paid the receipt for this customer. Try again';
}