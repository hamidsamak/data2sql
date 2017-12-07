# Data 2 SQL
A web-based project for converting tab and comma separated values like worksheets to SQL insert and update queries.

## Features
* Setting column names
* Skip or ignore selected columns of given data
* Working with tab-separated values (TSV) and comma-separated values (CSV)
* Trimming values

## Usage
### Insert example
```
1. Table name (e.g. test)
2. Column names (first,second,third,skip)
3. Columns order to skip (leave empty if all columns are necessary, in this case we skip fourth column *skip*)
4. Data as below:
1,2,3,A
4,5,6,B
7,8,9,C

Result:
INSERT INTO `test` (`first`, `second`, `third`) VALUES ('1', '2', '3');
INSERT INTO `test` (`first`, `second`, `third`) VALUES ('4', '5', '6');
INSERT INTO `test` (`first`, `second`, `third`) VALUES ('7', '8', '9');
```

### Update example
```
1. Table name (e.g. test)
2. Column names (first,second,third,id)
3. Columns order to skip (leave empty if all columns are necessary)
4. Data as below:
A,B,C,1
D,E,F,2
G,H,I,3

Result:
UPDATE `test` SET `first` = 'A', `second` = 'B', `third` = 'C' WHERE `id` = '1';
UPDATE `test` SET `first` = 'D', `second` = 'E', `third` = 'F' WHERE `id` = '2';
UPDATE `test` SET `first` = 'G', `second` = 'H', `third` = 'I' WHERE `id` = '3';
```
