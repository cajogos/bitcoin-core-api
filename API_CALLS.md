# :bulb: API Calls :bulb:

## GET Methods

:information_source: The following calls must be request using GET.

---
### :ok_hand: getinfo

- **URI:** `/getinfo`
- **Example:** `http://localhost/getinfo`

---
### :ok_hand: getwalletinfo

- **URI:** `/getwalletinfo`
- **Example:** `http://localhost/getwalletinfo`

---
### :ok_hand: getpeerinfo

- **URI:** `/getpeerinfo`
- **Example:** `http://localhost/getpeerinfo`

---
### :ok_hand: getbalance

- **URI:** `/getbalance`
- **Example:** `http://localhost/getbalance?account=carlos&confirmations=5&watchOnly=false`

**Params**

Name | Type | Presence | Description
--- | --- | --- | ---
`account` | string | optional | An account name, use * to display ALL (default), use empty string to display default account.
`confirmations` | int | optional | The minimum number of confirmations.
`watchOnly` | bool | optional | Whether to include watch-only addresses.

---
### :ok_hand: listtransactions

- **URI:** `/listtransactions`
- **Example:** `http://localhost/listtransactions?account=carlos&count=20&skip=10&watchOnly=true`

**Params**

Name | Type | Presence | Description
--- | --- | --- | ---
`account` | string | optional | The name of an account to get transactions from. Use an empty string (“”) to get transactions for the default account. (Default  * for ALL)
`count` | int | optional | The number of the most recent transactions to list. (Default 10)
`skip` | int | optional | The number of the most recent transactions which should not be returned. Allows for pagination of results. (Default 0)
`watchOnly` | bool | optional | Whether to include watch-only addresses. (Default false)

---
More coming as needed...

---
## POST Methods

:information_source: The following calls must be request using POST.

---
More coming needed...