# Runtime Monitor Command Line Application

Runtime monitor command line application checking the status of the provided uri's.

## Installation

You can install the application via git clone:

```bash
git clone https://github.com/Erth0/uptime-monitor.git
```
After cloning the repository we need to `composer install`.

Next we need to create 2 tables on our database.

### First Table (endpoints)
```sql
CREATE TABLE `endpoints` (
  `id` int(11) NOT NULL,
  `uri` text NOT NULL,
  `frequency` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
)
```

### Second Table (statuses)

```sql
CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `endpoint_id` int(11) NOT NULL,
  `status_code` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
)

ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statuses_ibfk_1` (`endpoint_id`);
  
  ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
  ALTER TABLE `statuses`
  ADD CONSTRAINT `statuses_ibfk_1` FOREIGN KEY (`endpoint_id`) REFERENCES `endpoints` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
```

## Usage

We have a few commands available to our application.
* `php uptime run` This will run all the endpoints
*  `php uptime run --force` This will force all the endpoints to run without wating for the frequency.
* `php uptime status` This will show the latest status of the endpoints.
![Uptime Monitor Status Table](https://github.com/Erth0/uptime-monitor/blob/master/Screenshot_1.png)
* `php uptime endpoint:add` This will add a new endpoint to the monitor.
*  `php uptime endpoint:add --frequency` This will add a new endpoint to the monitor with the provided frequency by default is 1.
* `php uptime endpoint:remove` This will remove an endpoint from the monitor based on the ID.

## Under the hood

This application will send you an SMS notification if any of the endpoints is down or is up back gain.
This can be extended with other notifications as well such as.
- Email Notification
- Slack Notification

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Feel free to submit any minor enhancements, but the goal here is to keep this as simple (yet as practical) as possible, so no huge additions. Thanks!
## Todo
- Showing all the responses statuses for an endpoint

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
