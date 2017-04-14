/* 1 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.ramingb<=2 and rpmishra.products.product_status='Refurbished'

select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.ramingb<=2 and rpmishra.products.product_status='Refurbished'

select part_id from parts where part_name='RAM'  AND main_property in('2GB','4GB') and consume_status='used' AND inventory=237


/* 2 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.ramingb in (3,4,6) and rpmishra.products.product_status='Refurbished'

select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.ramingb in (3,4,6) and rpmishra.products.product_status='Refurbished'

select part_id from parts where part_name='RAM'  AND main_property in('6GB','8GB','10GB') and consume_status='used' AND inventory=237

/* 3 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.ramingb in (10,8,16) and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.ramingb in (10,8,16) and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='RAM'  AND main_property in('16GB','10GB') and consume_status='used' AND inventory=237

/* 4 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.processor in ('AMD-A4','AMD-A6') and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.processor in ('AMD-A4','AMD-A6') and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='PROCESSOR'  AND main_property in('AMD-A6','AMD-A8') and consume_status='used' AND inventory=237

/* 5 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.processor in ('AMD-A8','AMD-A10') and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.processor in ('AMD-A8','AMD-A10') and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='PROCESSOR'  AND main_property in('AMD-A10') and consume_status='used' AND inventory=237


/* 6 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.processor in ('Pentium','Dualcore','Core2duo') and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.processor in ('Pentium','Dualcore','Core2duo') and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='PROCESSOR'  AND main_property in('Core2duo','i3') and consume_status='used' AND inventory=237

/* 7 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.processor in ('i3','i5') and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.processor in ('i3','i5') and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='PROCESSOR'  AND main_property in('i5','i7') and consume_status='used' AND inventory=237

/* 8 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.hddingb in (128,256,320) and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.HDDINGB in (128,256,320)and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='HDD'  AND main_property in('500GB','750GB') and consume_status='used' AND inventory=237

/* 9 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.hddingb in (500,750) and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.HDDINGB in (500,750)and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='HDD'  AND main_property in('1000GB','750GB','1500GB') and consume_status='used' AND inventory=237


/* 10 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.hddingb in (1500,1000) and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.HDDINGB in (1500,1000)and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='HDD'  AND main_property in('2000GB','1500GB') and consume_status='used' AND inventory=237


/* 11 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.battery is not null and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.BATTERY is not null and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='BATTERY'  and consume_status='used' AND inventory=237



/* 12 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.keyboard is not null and rpmishra.products.product_status='Refurbished'




select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.keyboard is not null and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='KEYBOARD'  and consume_status='used' AND inventory=237

/* Printers start here*/

/* 13 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.print_memory in (32,64,128) and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.print_memory in (32,64,128) and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='PRINTMEMORY' AND MAIN_property in ('64MB','128MB','256MB')  and consume_status='used' AND inventory=237




/* 14 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.print_memory in (256,512) and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.print_memory in (256,512) and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='PRINTMEMORY' AND MAIN_property in ('512MB')  and consume_status='used' AND inventory=237

/* 15 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.print_hard_drive in (230,256,512) and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.print_hard_drive in (230,256,512) and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='PRINTHDD' AND MAIN_property in ('512MB','750MB')  and consume_status='used' AND inventory=237

/* 16 */
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.print_hard_drive in (700,1000) and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.print_hard_drive in (700,1000) and rpmishra.products.product_status='Refurbished'


select part_id from parts where part_name='PRINTHDD' AND MAIN_property in ('1000MB','1500MB')  and consume_status='used' AND inventory=237


/* 17*/
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.catridge is not null and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.catridge is not null and rpmishra.products.product_status='Refurbished'


select part_id from parts where PART_NAME='CATRIDGE' and consume_status='used' AND inventory=237

/* 18*/
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.print_head is not null and rpmishra.products.product_status='Refurbished'


select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.print_head is not null and rpmishra.products.product_status='Refurbished'


select part_id from parts where PART_NAME='PRINTHEAD' and consume_status='used' AND inventory=237

/*19*/
select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.scanner is not null and rpmishra.products.product_status='Refurbished'

select count(product_id) from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=237 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.scanner is not null and rpmishra.products.product_status='Refurbished'


select part_id from parts where PART_NAME='SCANNER' and consume_status='used' AND inventory=237



