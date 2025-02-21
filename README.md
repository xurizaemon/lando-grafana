# Grafana and Graphite in Lando

This environment demonstrates a LAMP stack with additional observability services.

This stack runs _alongside_ your existing development environments and is used to observe those environments.

It provides:

- [x] [Alloy](http://alloy.o11y.lndo.site/) ([Docs](https://grafana.com/docs/alloy/latest/))
- [x] [Grafana](http://alloy.o11y.lndo.site/) ([Docs](https://grafana.com/docs/))
- [x] [Graphite](http://graphite.o11y.lndo.site/) ([Docs](https://graphite.dev/docs/get-started))
- [ ] [Loki](http://loki.o11y.lndo.site/) ([Docs](https://grafana.com/docs/loki/latest/?pg=oss-loki&plcmt=quick-links))
- [ ] [Mimir](http://mimir.o11y.lndo.site/) ([Docs](https://github.com/grafana/mimir))
- [ ] [Tempo](http://tempo.o11y.lndo.site/) ([Docs](https://grafana.com/docs/tempo/latest/))

It also contains an example environment which generates observability data and metrics.

## Usage

- Bring this environment up.
- Configure observability reporting on other local Lando projects
- Observe & interact

## Requirements

- Lando, Docker

## Setup

1. Clone this repository
2. `lando start`
3. Configure Grafana
4. Test it out

### Setup

- Visit http://grafana.test.lndo.site/
- Log in with `admin`/`admin`
- Press "skip" to avoid changing password
- Connections > Data source > Add new data source
- Choose type "Graphite"
  - Name is "Lando Graphite"
  - Source URL is `http://graphite.o11y.lndo.site:80`
- Explore data > Select "graphite" source
- Try a query of `*.*.*` - you should get some stats

### Provisioning

Where the heck did that go.

- Provision data sources
- Provision dashboards

### Service configurations

### Tempo

- Root shell: `lando ssh -s tempo -u root -c '/busybox/busybox sh'`

### Gathering data

Examples are in this repository which you should mirror in your project environment.

#### Collectd 

Configure Collectd in a Lando environment to gather metrics. See `appserver` example in this project for build steps and packages.

`config/collectd/`:
- `apache.conf` - Collectd will _read_ data from Apache's `server-status` endpoint (this depends on Apache configuration addition in `config/apache2/status.conf`).
- `graphite.conf` - Collectd will _write_ data to Graphite.
- `debug.conf` - Collectd will _write_ debug info (useful for configuring Collectd).
- `mysql.conf` - Collectd will _read_ MySQL performance and stats from the `database` service.
- `nginx.conf` - TBC
- `os.conf` - Collectd will _read_ OS metrics.

### Test it out

Most likely this is useful if you set up OTel reporting in an adjacent environment and use this project to observe that project.

This project contains an appserver service which is configured to gather metrics and observability data also. 

An example `index.php` and `database.php` are provided to generate some activity which can be observed.

```bash
$ ab -n 1000 -c 25 https://o11y.lndo.site/database.php
```
