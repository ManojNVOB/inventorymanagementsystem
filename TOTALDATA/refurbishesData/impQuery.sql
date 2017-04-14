select product_id from rpmishra.products, rpmishra.specification where rpmishra.products.inventory=201 
and rpmishra.specification.spec_id=rpmishra.products.specification 
and rpmishra.specification.keyboard in ('QWERTY','AZERTY') and rpmishra.products.product_status='Refurbished'


select product_id from products where product_status='Refurbished' and inventory=201 and (specification like 'L%'or specification like 'D%')
minus select product_id from refurbishes


select part_id from parts where (part_name='BATTERY' OR part_name='KEYBOARD') and consume_status='used' minus select part_id from  refurbishes

alter table refurbishes add constraint uniprod unique (product_id)