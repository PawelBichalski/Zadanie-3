<?php

namespace App\Tests\Validator;

use App\Validator\Constraints\IdentificationNumber;
use App\Validator\Constraints\IdentificationNumberValidator;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class IdentificationNumberValidatorTest extends TestCase
{
    /**
     * @dataProvider validIdentificationNumberProvider
     */
    public function testValidation(string $identificationNumber)
    {
        $constraint = new IdentificationNumber();

        $context = $this->getMockExecutionContext();
        $context->expects($this->never())->method('buildViolation');

        $validator = new IdentificationNumberValidator();
        $validator->initialize($context);

        $validator->validate($identificationNumber, $constraint);
    }

    /**
     * @dataProvider invalidIdentificationNumberProvider
     */
    public function testValidationFail(string $identificationNumber)
    {
        $constraint = new IdentificationNumber();

        $context = $this->getMockExecutionContext();
        $context->expects($this->once())
            ->method('buildViolation')
            ->with($constraint->message)
            ->willReturn($this->getMockConstraintViolationBuilder());

        $validator = new IdentificationNumberValidator();
        $validator->initialize($context);
        $validator->validate($identificationNumber, $constraint);
    }

    private function getMockExecutionContext()
    {
        $context = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $context;
    }

    private function getMockConstraintViolationBuilder()
    {
        $constraintViolationBuilder = $this->getMockBuilder(ConstraintViolationBuilderInterface::class)->getMock();
        $constraintViolationBuilder
            ->method('setParameter')
            ->willReturn($constraintViolationBuilder);
        $constraintViolationBuilder
            ->method('setCode')
            ->willReturn($constraintViolationBuilder);
        $constraintViolationBuilder
            ->method('addViolation');
        return $constraintViolationBuilder;
    }

    public function validIdentificationNumberProvider()
    {
        return [
            ['99042622464'],
            ['62090198443'],
            ['80042977463'],
            ['58091478556'],
            ['68033181316'],
        ];
    }

    public function invalidIdentificationNumberProvider()
    {
        return [
            ['12345678901'],
            ['12345678901234'],
            ['123'],
            ['84051822849'],
            ['83082336387'],
        ];
    }
}
