<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ventas_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Venta/productos_model', 'p');
        $this->load->model('Cliente/cliente_model', 'c');
        $this->load->model('Venta/ventas_model', 'v');

    }

    public function index()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Generar Ventas';
            $datos['contenido'] = 'ventas_generar_view';
            $datos["modulo"] = "Ventas";
            $filejs=['Clientes/clientedata','ventas/ventadata'];
            $datos['filesjs'] = $filejs;
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }
    public function add_carrito()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            if (isset($_POST["productoid"])) {
                $id = $_POST["productoid"];
                $venta = $this->session->userdata('venta');
                if (isset($venta[$id])) {
                    $venta[$id]['cantidad']++;
                    $msg = "Se Incremento ";
                    $status = true;
                    $this->session->set_userdata('venta', $venta);
                } else {
                    $producto = $this->p->get_find_producto_id($id);
                    if ($producto != false) {
                        $venta[$id] = [
                            "productoid" => $producto->id,
                            "nombre" => $producto->nombre,
                            "cantidad" => 1,
                            "precio" => $producto->precio,
                            "dsctoimpo" => 0,
                            "dsctosimb" => '',
                            "imagen" => '',
                        ];
                        $msg = "Se Agrego";
                        $status = true;
                        $this->session->set_userdata('venta', $venta);
                    } else {
                        $msg = "Se presento error";
                        $status = false;
                    }

                }
                $total_items = count($this->session->userdata('venta'));
                $datas['items'] = $total_items;                
               
                header('Content-type: application/json; charset=utf-8');
                echo json_encode(array("status" => $status, "info" => $msg));
            }
        } else {
            redirect('salir');
        }

    }
    public function delete_carrito()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            if (isset($_POST["productoid"])) {
                $id = $_POST["productoid"];
                $venta = $this->session->userdata('venta');
                if (isset($venta[$id])) {
                    unset($venta[$id]);
                    $msg = "Se Quito ";
                    $validate = true;
                    $this->session->set_userdata('venta', $venta);
                } else {
                    $msg = "No se Quito item";
                    $validate = false;
                }
                $total_items = count($this->session->userdata('venta'));
                $datas['items'] = $total_items;
                $datas['validate'] = $validate;
                $datas['info'] = $msg;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($datas);
            }
        } else {
            redirect('salir');
        }

    }

    public function formapago()
    {
        $datos['titulo'] = 'Forma Pago Ventas';
        $datos['contenido'] = 'ventas_formapago_view';
        $datos["modulo"] = "ventas";
        $this->load->view('includes/plantilla', $datos);
    }

    public function pago()
    {
        $datos['titulo'] = 'Forma Pago Ventas';
        $datos['contenido'] = 'ventas_pago_view';
        $datos["modulo"] = "ventas";
        $this->load->view('includes/plantilla', $datos);
    }

    public function buscarproducto()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = strtolower($this->security->xss_clean($this->input->post('producto', true)));            
            if (empty($id) && strlen($id)>=0) {
                $status = false;
                $msg = 'No puede enviar una busqueda en blanco ' . $id;
            } else {
                $data = $this->p->get_find_producto_word($id);
                if ($data != false) {
                    $status = true;
                    $msg = $data;
                } else {
                    $status = false;
                    $msg = 'No hay resultados ' . $data;
                }
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode(array("status" => $status, "info" => $msg));
        } else {
            redirect('salir');
        }
    }
    public function get_producto_id()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = $this->security->xss_clean($this->input->post('productoid', true));
            $data = $this->p->get_find_producto_id($id);
            if ($data != false) {
                $validate = true;
                $msg = $data;
            } else {
                $validate = false;
                $msg = 'No hay resultados';
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }

    public function get_producto_storage()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = $this->security->xss_clean($this->input->post('productoid', true));
            $data = $this->p->get_producto_storage_id($id);
            if ($data != false) {
                $validate = true;
                $msg = $data;
            } else {
                $validate = false;
                $msg = 'No hay resultados';
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }
    public function get_stock_categoria()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = $this->security->xss_clean($this->input->post('productoid', true));
            $data = $this->p->get_stock_categoria();
            if ($data != false) {
                $validate = true;
                $msg = $data;
            } else {
                $validate = false;
                $msg = 'No hay resultados';
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }
    public function get_productovendedor()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {

            $data = $this->p->get_productovendedor();
            if ($data != false) {
                $validate = true;
                $msg = $data;
            } else {
                $validate = false;
                $msg = 'No hay resultados';
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }
    public function get_productovendedor_addlist()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $data = $this->p->get_productovendedor_show();
            if ($data != false) {
                $validate = true;
                $msg = $data;
            } else {
                $validate = false;
                $msg = 'No hay resultados';
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }

    public function save_productovendedor()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = $this->security->xss_clean($this->input->post('productoid', true));
            $dataex = $this->p->get_productovendedor_id($id);
            if ($dataex == false) {
                $data = $this->p->save_productovendedor($id);
                if ($data != false) {
                    $validate = true;
                    $msg = 'se registro la a los favoritos';
                } else {
                    $validate = false;
                    $msg = 'No se registro la actualizacion';
                }
            } else {
                $data = $this->p->update_productovendedor($dataex->id);
                if ($data != false) {
                    $validate = true;
                    $msg = 'se actualizo a los favoritos';
                } else {
                    $validate = false;
                    $msg = 'No se actualizo ocurrio un probelma';
                }
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }
    public function delete_productovendedor()
    {
        $valid = $this->session->userdata('validated');
        if ($valid == true) {
            $id = $this->security->xss_clean($this->input->post('productovendedorid', true));
            $data = $this->p->delete_productovendedor($id);
            if ($data != false) {
                $validate = true;
                $msg = 'Se eliminao de su favorito';
            } else {
                $validate = false;
                $msg = 'No hay resultados';
            }
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }

    public function buscarcliente()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $clientedat = $this->input->post('clientedat', true);
            $msg = $this->security->xss_clean($clientedat);
            $validate = true;
            /* $data = $this->c->get_find_cliente_word($id);
            if ($data != false) {
            $validate = true;
            $msg = $data;
            } else {
            $validate = false;
            $msg = 'No hay resultados';
            }*/
            $datas['info'] = $msg;
            $datas['validate'] = $validate;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($datas);
        } else {
            redirect('salir');
        }
    }
    public function ventas()
    {$valid = $this->session->userdata('validated');
        if ($valid == true) {
            $datos['titulo'] = 'Lista Ventas';
            $datos['contenido'] = 'ventas_view';
            $datos["modulo"] = "ventas";
            $this->load->view('includes/plantilla', $datos);
        } else {
            redirect('salir');
        }
    }

}