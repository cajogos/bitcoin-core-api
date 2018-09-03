# :star: PHP Bitcoin Core JSON RPC API wrapper :star:

A wrapper for Bitcoin Core's JSON RPC API written in PHP, running on a [Biscuit Link](https://biscuit.link) application.

This is to be considered as a middleware and it's advisable to write your application on top of this interface, making your wallet daemon even more secure :lock:.

**Here's how:**
```
[Wallet] <--> [[[ This ]]] <--> [Your Backend] <--> [Your Client]
```

Keeping these systems separate is a good idea to stop them nasty :smiling_imp: who want your cryptos.

## API Calls

The calls here are pretty much the same as [Bitcoin Developer Reference](https://bitcoin.org/en/developer-reference#remote-procedure-calls-rpcs), and they are built using its values.

### GET Methods

#### :ok_hand: getinfo

- **URI:** `/getinfo`
- **Example:** `http://localhost/getinfo`

##### Params

None.

#### :ok_hand: getbalance

- **URI:** `/getbalance`
- **Example:** `http://localhost/getbalance?account=carlos&confirmations=5&watchOnly=false`

##### Params

Name | Type | Presence | Description
--- | --- | --- | ---
`account` | string | optional | An account name, use * to display ALL (default), use empty string to display default account.
`confirmations` | int | optional | The minimum number of confirmations.
`watchOnly` | bool | optional | Whether to include watch-only addresses.

More coming soon...

### POST Methods

More coming soon...


## About The Project

This project was built on top of my other Open Source, PHP framework, project [Biscuit Link](https://biscuit.link).

Find out more about the author by going to [https://carlos.fyi](https://carlos.fyi).