#!/bin/bash

CLASSPATH=.:/usr/lib/oracle/12.1/client64
CLASSPATH=$CLASSPATH:/usr/lib/oracle/12.1/client64/lib/ojdbc7.jar
CLASSPATH=$CLASSPATH:/usr/lib/oracle/12.1/client64/lib/ottclasses.zip
export  CLASSPATH

echo "Content-type: text/plain"
echo ""

/usr/bin/java -Djava.security.egd=file:/dev/./urandom  Customers
