class migrate{

	exec{ '/usr/bin/php -f /vagrant/www/SiGA/index.php migrate':
	command => '/usr/bin/php -f /vagrant/www/SiGA/index.php migrate',
	require => Package['phpmyadmin'],
	}
}
