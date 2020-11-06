

<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Factura</title>
  <style>


    #page_pdf{
      width: 95%;
      margin: 15px auto 10px auto;
    }

    #factura_head,#factura_cliente,#factura_detalle{
      width: 100%;
      margin-bottom: 10px;
    }

    #detalle_productos tr:nth-child(even) {
      background: #ededed;
      border-radius: 10px;
      border: 1px solid #3d7ba8;
      overflow: hidden;
      padding-bottom: 15px;

    }

    #detalle_totales span{
      font-family: 'BrixSansBlack';
      text-align: right; 
    }
    
    .logo_factura{
      width: 25%;
    }

    .info_empresa{
      width: 50%;
      text-align: center;
    }
    
    .info_factura{
      width: 31%;
    }

    .info_cliente{
      width: 69%;
    }

    .textright{
      padding-left: 3;
    }


    .h3{
      font-family: 'BrixSansBlack';
      font-size: 8pt;
      display: block;
      background: #3d7ba8;
      color: #FFF;
      text-align: center;
      padding: 3px;
      margin-bottom: 5px;
    }

    .round{
      border-radius: 10px;
      border: 1px solid #3d7ba8;
      overflow: hidden;
      padding-bottom: 15px;
    }

    table{
       border-collapse: collapse;
       font-size: 12pt;
       font-family: 'arial';
       width: 100%;
    }


    table tr:nth-child(odd){
       background: #FFF;
    }
    
    table td{
      padding: 4px;


    }

    table th{
       text-align: left;
       color:#3d7ba8;
       font-size: 1em;
    }

    .datos_cliente
    {
      font-size: 0.8em;
    }

    .datos_cliente label{
       width: 75px;
       display: inline-block;
    }

    .lab{
      font-size: 18px;
      font-family: 'arial';
    }

    *{
      font-family:'Arial' !important;
    }

    .mLabel{
      width:20%;
      display: inline-block;
      vertical-align: top;
      font-weight: bold;
      padding-left:15px;
      font-size: 0.9em;

    }
    .mValue{
      width:79%;
      display: inline-block;
      vertical-align: top;
      padding-left:7px;
      font-size: 0.9em;
    }

    .totals_wrapper{
      width:100%;
    }
    .totals_label{
      display: inline-block;
      vertical-align: top;
      width:85%;
      text-align: right;
      font-size: 0.7em;
      font-weight: bold;
      font-family: 'Arial';
    }
    .totals_value{
      display: inline-block;
      vertical-align: top;
      width:14%;
      text-align: right;
      font-size: 0.7em;
      font-weight: normal;
      font-family: 'Arial';
    }
    .totals_separator{
      width:100%;
      height:1px;
      clear: both;
    }

    .separator{
      width:100%;
      height:60px;
      clear: both;
    }

    .details_title_border_left{
      background: #3d7ba8;
      border-top-left-radius: 10px;
      color:#FFF;
      padding: 10px;
      padding-left:10px;
    }

    .details_title_border_right{
      background: #3d7ba8;
      border-top-right-radius: 10px;
      color:#FFF;
      padding: 10px;
      padding-right:3px;
    }

    .details_title{
      background: #3d7ba8;
      color:#FFF;      
      padding: 10px;
    }
  </style>


</head>
@php
  $subtotal   = 0;
  $iva    = 0;
  $impuesto   = 0;
  $tl_sniva   = 0;
  $total    = 0;
@endphp

<body>

  <div id="page_pdf">
    <table id="factura_head">
      <tr>
        <!--INSTITUTO ECUATORIANO DE ENFERMEDADES DIGESTIVAS GASTROCLINICA S.A-->
        
        
        <td class="info_empresa">
          <div style="text-align: center">
            <img src="{{base_path().'/storage/app/logo/iec_logo1391707460001.png'}}"  style="width:350px;height: 150px">
          </div>
          <div style="text-align: center; font-size:0.8em">
            R.U.C.: {{$empresa->ci}}<br/>
            Nombre Comercial: {{$empresa->nombre}}<br/>
            Teléfono: {{$empresa->telefono}}<br/>
            Dir.Matriz: {{$empresa->direccion}}<br/>
            <br/>
          </div>
        </td>
        <td class="info_factura">
          <div class="round">
            <span class="h3" style="padding:20px">FACTURA</span>
            <p  style="padding-left:20px;padding-right:20px;padding-top:0px;padding-bottom:0px">
              No. Factura:<strong> @if(($fact_venta->nro_comprobante)!=null) {{$fact_venta->nro_comprobante}} @endif</strong><br/>
              Fecha: {{$fact_venta->fecha}}<br/>
             
            </p>
          </div>
        </td>
       
      </tr>
    </table>

    <table id="factura_cliente">
      <tr>
        <td class="info_cliente">
          <div class="round">
            <div class="col-md-12">
              <table class="datos_cliente">
                <tr>
                  <td width="50%">
                    <div class="mLabel">
                      CLIENTE:
                    </div>
                  </td>
                  <td width="50%">
                    <div class="mValue">
                      @if(!is_null($fact_venta->cliente))
                      {{trim($fact_venta->cliente->nombre)}}
                      @endif
                    </div>
                  </td>
                </tr>
                <tr>
                  <td width="15%">
                    <div class="mLabel">
                    DIRECCION:
                    </div>
                  </td>
                  <td width="35%">
                    <div class="mValue">
                    {{$fact_venta->cliente->direccion}}
                    </div>
                  </td>
                </tr>
                <tr>
                  <td width="15%">
                    <div class="mLabel">
                    TELÉFONO:
                    </div>
                  </td>
                  <td width="35%">
                    <div class="mValue">
                    {{$fact_venta->cliente->telefono}}
                    </div>
                  </td>
                </tr>
                <tr>
                  <td width="15%">
                    <div class="mLabel">
                    FECHA:
                    </div>
                  </td>
                  <td width="35%">
                    <div class="mValue">
                    {{$fact_venta->fecha}}
                    </div>
                  </td>
                  <td width="15%">
                    <div class="mLabel">
                    
                    </div>
                  </td>
                  <td width="35%">
                    <div class="mValue">
                    
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td> 
      </tr>
    </table>
    <table id="factura_detalle" cellpadding="0" cellpadding="0">
      <thead>
        <tr>
          <th style="font-size: 16px;"><div class="details_title_border_left">CÓDIGO</div></th>
          <th style="font-size: 16px"><div class="details_title">DESCRIPCIÓN</div></th>
          <th style="font-size: 16px"><div class="details_title">CANTIDAD</div></th>
          <th style="font-size: 16px"><div class="details_title">PRECIO</div></th>
          <th style="font-size: 16px"><div class="details_title_border_right">TOTAL</div></th>
        </tr>
      </thead>
      <tbody id="detalle_productos" >
      @if(($fact_venta->detalle)!=null)
        @foreach ($fact_venta->detalle as $value)
          <tr class="round">
            <td style="font-size: 16px">
              @if(!is_null($value->codigo))
                {{$value->codigo}}
              @endif
            </td>
            @endphp
            <td style="font-size: 16px">
              @if(!is_null($value->nombre))
                <label>{{$value->nombre}}</label>
              @endif
            </td>
            <td  style="font-size: 16px;">
              @if(!is_null($value->cantidad))
                {{$value->cantidad}}
              @endif
            </td>
            <td  style="font-size: 16px;">
              @if(!is_null($value->precio))
                {{$value->precio}}
                
              @endif
            </td>
            <td  style="font-size: 16px;">
              @if(!is_null($value->total))
                {{$value->total}}
              @endif
            </td>
          </tr>
        @endforeach
      @endif   
      </tbody>
    </table>
    <div class="separator"></div>
    <div class="totals_wrapper">
          <div class="totals_label">
              SUBTOTAL 0%
          </div>
          <div class="totals_value">
              @if(!is_null($fact_venta->subtotal0))
                {{$fact_venta->subtotal0}}
              @endif
          </div>
          <div class="totals_separator"></div>
          <div class="totals_label">
              SUBTOTAL 12%
          </div>
          <div class="totals_value">
              @if(!is_null($fact_venta->subtotal12))
                {{$fact_venta->subtotal12}}
              @endif
          </div>
          <div class="totals_separator"></div>
          <div class="totals_label">
              BASE IMPONIBLE:
          </div>
          <div class="totals_value">
              @if(!is_null($fact_venta->subtotal))
                {{$fact_venta->subtotal}}
              @endif
          </div>
          <div class="totals_separator"></div>
          <div class="totals_label">
              TARIFA 12%
          </div>
          <div class="totals_value">
              @if(!is_null($fact_venta->iva_total))
                  {{$fact_venta->iva_total}}
              @endif
          </div>
          <div class="totals_separator"></div>
          <div class="totals_label">
              TOTAL
          </div>
          <div class="totals_value">
              @if(!is_null($fact_venta->total_final))
                {{$fact_venta->total_final}}
              @endif
          </div>
    </div>
    <div class="separator"></div>
    <div>
      <!--FormaS de Pago-->
     
    </div>
    <div class="separator"></div>
  </div>

</body>
</html>  