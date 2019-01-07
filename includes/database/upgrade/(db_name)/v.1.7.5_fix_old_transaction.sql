UPDATE transactions SET transactions.dateverify = UNIX_TIMESTAMP(transactions.createdate)  WHERE transactions.dateverify IS NULL AND transactions.verify = 1;
