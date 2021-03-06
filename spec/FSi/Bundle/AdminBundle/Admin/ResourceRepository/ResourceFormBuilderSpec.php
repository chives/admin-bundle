<?php

namespace spec\FSi\Bundle\AdminBundle\Admin\ResourceRepository;

use FSi\Bundle\AdminBundle\Exception\RuntimeException;
use FSi\Bundle\AdminBundle\Form\TypeSolver;
use FSi\Bundle\AdminBundle\Admin\ResourceRepository\GenericResourceElement;
use FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValue;
use FSi\Bundle\ResourceRepositoryBundle\Model\ResourceValueRepository;
use FSi\Bundle\ResourceRepositoryBundle\Repository\MapBuilder;
use FSi\Bundle\ResourceRepositoryBundle\Repository\Resource\Type\TextType;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use FSi\Bundle\ResourceRepositoryBundle\Form\Type\ResourceType;

class ResourceFormBuilderSpec extends ObjectBehavior
{
    function let(
        MapBuilder $mapBuilder,
        FormFactoryInterface $formFactory,
        GenericResourceElement $element,
        ResourceValueRepository $valueRepository,
        TextType $resource
    ) {
        $mapBuilder->getMap()->willReturn([
            'resources' => [
                'resource_key' => $resource
            ]
        ]);
        $resource->getName()->willReturn('resources.resource_key');

        $element->getResourceValueRepository()->willReturn($valueRepository);
        $element->getResourceFormOptions()->willReturn(['form_options']);

        $this->beConstructedWith($formFactory, $mapBuilder);
    }

    function it_throws_exception_when_resource_key_is_not_resource_group_key(GenericResourceElement $element)
    {
        $element->getKey()->willReturn('resources.resource_key');

        $this->shouldThrow(
            new RuntimeException('resources.resource_key its not a resource group key')
        )->during('build', [$element]);
    }

    function it_builds_form_for_resource_group(
        FormFactoryInterface $formFactory,
        FormBuilderInterface $formBuilder,
        GenericResourceElement $element,
        ResourceValueRepository $valueRepository,
        ResourceValue $resourceValue,
        FormInterface $form
    ) {
        $element->getKey()->willReturn('resources');
        $valueRepository->get('resources.resource_key')->willReturn($resourceValue);

        $formFactory
            ->createBuilder(
                TypeSolver::getFormType(FormType::class, 'form'),
                ['resources_resource_key' => $resourceValue],
                ['form_options']
            )
            ->willReturn($formBuilder);

        $formBuilder
            ->add(
                'resources_resource_key',
                TypeSolver::getFormType(ResourceType::class, 'resource'),
                ['resource_key' => 'resources.resource_key']
            )
            ->shouldBeCalled();

        $formBuilder->getForm()->willReturn($form);

        $this->build($element)->shouldReturn($form);
    }
}
