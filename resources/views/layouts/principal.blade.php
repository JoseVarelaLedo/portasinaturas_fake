@extends('index')

@section('normal_content')
    <div class="container contido-informativo py-4">
        <div class="row">
            <div class="col-md-8 text-center">
                <h1>Proxecto Tramitación Enerxías Renovables</h1>
            </div>
            <div class="col-md-4 text-center">
                <img src="img/renovables_01.jpg" alt="Renovables 01" style="width: 400px;border-radius:5px" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 text-center">
                <img src="img/renovables_04.jpg" alt="Renovables 04" style="width: 450px" />
            </div>
            <div class="col-md-10 text-center">
                <h2>Actuacións subvencionables</h2>
                <p> Serán subvencionables as seguintes actuacións que se executen en zonas rurais da Comunidade Autónoma de
                    Galicia (consultar listaxe de parroquias elixibles) e presenten un investimento mínimo de 6.000 euros
                    (IVE non incluído):

                    a) Proxectos de enerxías renovables eléctricas: Serán subvencionables os custes dos investimentos
                    necesarios para o desenvolvemento de instalacións que xeren electricidade a partir de fontes de enerxías
                    renovables. En concreto, serán subvencionables as instalacións de xeración eléctrica mediante tecnoloxía
                    fotovoltaica ou minieólica (aos efectos desta convocatoria considérase minieólica aquelas instalacións
                    cunha potencia nominal inferior ou igual a 100 kW) asociadas a algún centro de traballo do sector
                    agrícola primario na modalidade de subministración con autoconsumo.

                    Os módulos fotovoltaicos deberán ter unha eficiencia enerxética igual ou superior ao 21 % para unha
                    irradiación de 1000 W/m2 e a unha temperatura de 25 ºC.

                    O investimento elixible máximo por potencia unitaria nominal da instalación será de 1.000 €/kW para
                    instalacións fotovoltaicas e 2.500 €/kW para instalacións minieólicas, IVE non incluído.
                    Aos efectos destas bases considérase potencia nominal da instalación a potencia mínima entre a potencia
                    nominal dos inversores e o sumatorio da potencia pico dos paneis/aeroxeradores instalados. En
                    instalacións illadas da rede a potencia nominal coincidirá co sumatorio da potencia pico dos
                    paneis/aeroxeradores instalados.

                    b) Proxectos de aforro e eficiencia enerxética Será subvencionable o sobrecusto de investimento
                    necesarios para lograr un nivel máis elevado de eficiencia enerxética. As actuacións deben xustificar un
                    aforro enerxético mínimo en relación a situación inicial de 0,1 kWh de enerxía final por cada euro de
                    investimento elixible. Non serán subvencionables a instalación de equipos de enerxía alimentados por
                    combustibles fósiles, incluído o gas natural.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 text-start">
                <h2>Características das axudas</h2>
                <div>
                    <p>A convocatoria conta cun orzamento de 1.305.000,00 € financiada con fondos FEADER desagregado por
                        tipoloxía de proxecto conforme ao indicado na seguinte táboa:</p>

                    <p>Liña de axuda Total (€)<br>
                        RE - Proxectos de enerxías renovables eléctricas 1.000.000,00<br>
                        PAE - Proxectos de aforro e eficiencia enerxética 305.000,00<br>
                        Total 1.305.000,00</p>

                    <p>A concesión das axudas realizarase en réxime de concorrencia competitiva, asignando os fondos en
                        función
                        dos seguintes criterios de baremación:</p>

                    <ol>
                        <li>
                            Características técnicas (ata 50 puntos)
                            Para proxectos de aforro e eficiencia enerxética valorarase o cociente de aforro de enerxía por
                            cada
                            euro de investimento elixible (kWh de aforro/ € de investimento elixible).
                            Para proxectos de enerxías renovables valorarase:
                            <ul>
                                <li>Incidencia do custo enerxético na competitividade do centro de traballo: Valorarase a
                                    razón
                                    de 3
                                    puntos por cada 1 % que representen os custos enerxéticos da empresa en relación cos
                                    custos
                                    totais no
                                    último exercicio do que se teña información ata un máximo de 30 puntos.</li>
                                <li>Instalacións renovables preexistentes.
                                    <ul>
                                        <li>Con instalación preexistente da mesma tecnoloxía renovable: 0 puntos.</li>
                                        <li>Sen instalación preexistente da mesma tecnoloxía renovable: 20 puntos.</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            Explotacións agrarias prioritarias (ata 20 puntos)
                            Outórgase 20 puntos as explotacións inscritas na sección de explotacións agrarias prioritarias
                            do
                            Rexistro de Explotacións Agrarias de Galicia (REAGA).
                        </li>
                        <li>
                            Localización xeográfica do proxecto (ata 30 puntos)
                            Valoraranse os proxectos en función da renda dispoñible bruta por habitante do concello no que
                            se
                            desenvolvan priorizando os que se ubiquen en zonas economicamente menos favorecidas.
                            A puntuación mínima requirida para que o proxecto cumpra a finalidade da convocatoria e se
                            considere
                            subvencionable se establece en 30 puntos.
                        </li>
                    </ol>
                </div>
            </div>
            <div class="col-md-3">
                <img src="img/renovables_03.jpg" alt="Renovables 03" style="width: 300px" />
            </div>
            <div class="row">
                <div class="col-md-5">
                    <img src="img/renovables_02.jpg" alt="Renovables 02" style="width: 600px" />
                </div>
                <div class="col-md-7">
                    <h3>Beneficiarios</h3>
                    <em>Poderán ser beneficiarios das subvencións, sen prexuízo de reuniren os demais requisitos establecidos
                    nestas bases, os suxeitos que se enumeran a continuación:

                    a) As empresas legalmente constituídas e os empresarios autónomos, que teñan domicilio social ou algún
                    centro de traballo en Galicia, incluídas no sector de produción agrícola primaria. Considerarase sector
                    de produción agrícola primaria as actividades incluídas na sección A e en concreto as clases da 1.11 a
                    02.40 do CNAE-2025 ambas incluídas. Tamén serán subvencionables as actividades contempladas no IAE que
                    se correspondan con estas clases do CNAE 2025.

                    Ós efectos destas bases terase en conta a definición de empresa recollida no anexo I do Regulamento
                    651/2014 no cal se considerará empresa toda entidade, independentemente da súa forma xurídica, pública o
                    privada, que exerza unha actividade económica.

                    b) As empresas de servizos enerxéticos que xestionen total ou parcialmente instalacións consumidoras de
                    enerxía. Os centros de consumo nos que se actúe deben estar situados en Galicia e corresponder a
                    empresas incluídas no ámbito de actuación das presentes bases e, en concreto, desenvolver algunha das
                    actividades recollidas no apartado anterior.</em>
                </div>
            </div>
        </div>
    @endsection
