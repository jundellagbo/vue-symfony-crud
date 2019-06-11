<?php
namespace App\Controller;
use App\Entity\Names;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NamesController extends Controller {
    /**
     * @Route("/names", name="name_list")
     * @Method({"GET"})
     */
    public function index() {
        /**
         * Retrieve
         */
        $names = $this->getDoctrine()->getRepository(Names::class);
        return new JsonResponse(array( 'items' => $names->findAll() ));
    }
    
    /**
     * @Route("/names/save", name="name_store")
     * @Method({"POST"})
     */
    public function save( Request $request ) {
        /**
         * Create and Update
         */
        $param = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();
        $storename = $param['id'] != 0 ? $this->getDoctrine()->getRepository(Names::class)->find( $param['id'] ) : new Names();
        $storename->setFullname( $param['fullname'] );
        $entityManager->persist( $storename );
        $entityManager->flush();
        return new JsonResponse( array( 'response' => $storename ) );
    }

    /**
     * @Route("/names/remove/{id}", name="name_remove")
     * @Method({"GET"})
     */
    public function delete( $id ) {
        /**
         * Delete
         */
        $name = $this->getDoctrine()->getRepository(Names::class)->find( $id );
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove( $name );
        $entityManager->flush();
        return new JsonResponse( array( 'status' => 'removed' ) );
    }
}