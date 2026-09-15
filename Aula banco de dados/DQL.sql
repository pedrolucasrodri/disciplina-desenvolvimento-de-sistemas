 -- reservas

select
    tb2.nome_cliente as Nome_cliente,
    tb2.pk_cpf as CPF,
    tb2.num_celular as Numero,
	date_format(tb1.dt_retirada,'%d/%m/%Y') AS Data_reserva,
    time_format(tb1.hr_retirada,'%h:%i') as Hora_reserva,
    
    case
		when tb1.tp_retirada = 'A' then 'Agencia'
        when tb1.tp_retirada = 'C' then 'Cliente'
	end as Tipo_reserva,
    
    tb3.marca Marca,
    tb3.modelo as Modelo,
    tb3.pt_motor as Potencia_motor,
	tb3.ano as Ano,
    tb3.placa as Placa,
    tb1.valor as Valor,
    tb3.categoria as Categoria

from db_begin.reserva tb1

left join db_begin.cliente tb2 on
tb1.fk_cpf = tb2.pk_cpf

left join db_begin.carro tb3 on 
tb1.fk_chassi = tb3.pk_chassi;